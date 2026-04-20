#!/usr/bin/env bash

set -euo pipefail

REPO_URL="https://github.com/raexera/MyLinx.git"
DEPLOY_USER="deploy"
APP_DIR="/opt/mylinx"

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log()  { echo -e "${GREEN}[bootstrap]${NC} $*"; }
warn() { echo -e "${YELLOW}[bootstrap]${NC} $*"; }
err()  { echo -e "${RED}[bootstrap]${NC} $*"; exit 1; }

[[ $EUID -eq 0 ]] || err "Must run as root. Try: sudo bash bootstrap.sh"

log "Step 1/8: Updating system packages..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get upgrade -y -qq
apt-get install -y -qq ca-certificates curl gnupg lsb-release ufw git

log "Step 2/8: Creating 2GB swap file (helps on 1GB Droplet)..."
if [[ ! -f /swapfile ]]; then
    fallocate -l 2G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile >/dev/null
    swapon /swapfile
    echo '/swapfile none swap sw 0 0' >> /etc/fstab
    log "  → 2GB swap created and enabled"
else
    log "  → Swap already exists, skipping"
fi

log "Step 3/8: Installing Docker..."
if ! command -v docker &>/dev/null; then
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    chmod a+r /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(. /etc/os-release && echo "$VERSION_CODENAME") stable" \
        > /etc/apt/sources.list.d/docker.list
    apt-get update -qq
    apt-get install -y -qq docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
    systemctl enable docker
    systemctl start docker
    log "  → Docker installed"
else
    log "  → Docker already installed, skipping"
fi

log "Step 4/8: Creating deploy user..."
if ! id -u "$DEPLOY_USER" &>/dev/null; then
    useradd -m -s /bin/bash "$DEPLOY_USER"
    usermod -aG docker "$DEPLOY_USER"
    # Allow passwordless sudo for docker operations
    echo "$DEPLOY_USER ALL=(ALL) NOPASSWD: /usr/bin/docker, /usr/bin/docker-compose" > /etc/sudoers.d/deploy-docker
    chmod 0440 /etc/sudoers.d/deploy-docker
    log "  → Created user '$DEPLOY_USER'"
else
    log "  → User '$DEPLOY_USER' already exists, skipping"
fi

log "Step 5/8: Configuring UFW firewall..."
ufw default deny incoming >/dev/null
ufw default allow outgoing >/dev/null
ufw allow 22/tcp  >/dev/null  # SSH
ufw allow 80/tcp  >/dev/null  # HTTP
# Add 443 when you set up HTTPS/domain
ufw --force enable >/dev/null
log "  → Firewall enabled (ports 22, 80 open)"

log "Step 6/8: Cloning MyLinx repo to $APP_DIR..."
if [[ ! -d "$APP_DIR" ]]; then
    git clone "$REPO_URL" "$APP_DIR"
    chown -R "$DEPLOY_USER:$DEPLOY_USER" "$APP_DIR"
    log "  → Repo cloned"
else
    log "  → Repo already exists, skipping"
fi

log "Step 7/8: Setting up initial .env..."
if [[ ! -f "$APP_DIR/src/.env" ]]; then
    cp "$APP_DIR/.env.production.example" "$APP_DIR/src/.env"
    chown "$DEPLOY_USER:$DEPLOY_USER" "$APP_DIR/src/.env"
    chmod 600 "$APP_DIR/src/.env"

    # Generate random DB password
    DB_PASSWORD=$(openssl rand -base64 24 | tr -d '/=+' | cut -c1-32)
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD|" "$APP_DIR/src/.env"

    # Auto-detect Droplet public IP
    PUBLIC_IP=$(curl -fsSL -4 ifconfig.me 2>/dev/null || echo "YOUR_DROPLET_IP")
    sed -i "s|^APP_URL=.*|APP_URL=http://$PUBLIC_IP|" "$APP_DIR/src/.env"

    log "  → .env created with auto-detected IP: $PUBLIC_IP"
    log "  → DB password auto-generated (see $APP_DIR/src/.env)"
else
    warn "  → .env already exists, skipping (review manually if needed)"
fi

log "Step 8/8: Building and starting containers..."
cd "$APP_DIR"
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml build
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml up -d

log "Waiting for database to be ready..."
sleep 15

log "Running Laravel setup (key, migrate, storage link, cache)..."
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan key:generate --force
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan migrate --force
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan db:seed --force
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan storage:link
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan config:cache
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan route:cache
sudo -u "$DEPLOY_USER" docker compose -f docker-compose.prod.yml exec -T app php artisan view:cache

PUBLIC_IP=$(curl -fsSL -4 ifconfig.me 2>/dev/null || echo "YOUR_DROPLET_IP")

echo ""
echo "═══════════════════════════════════════════════════════════"
log "BOOTSTRAP COMPLETE"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "  Visit:     http://$PUBLIC_IP"
echo "  SSH user:  $DEPLOY_USER (add your SSH key to ~/.ssh/authorized_keys)"
echo "  App dir:   $APP_DIR"
echo ""
echo "  Next steps:"
echo "    1. Seed test credentials: see /opt/mylinx/src/database/seeders/DatabaseSeeder.php"
echo "    2. Add your SSH public key to /home/$DEPLOY_USER/.ssh/authorized_keys"
echo "    3. Disable root SSH login: sudo sed -i 's/^PermitRootLogin.*/PermitRootLogin no/' /etc/ssh/sshd_config && sudo systemctl reload sshd"
echo "    4. For future deploys, run: cd $APP_DIR && git pull && make prod-deploy"
echo ""
echo "═══════════════════════════════════════════════════════════"
