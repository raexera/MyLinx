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

log "Step 1/9: Updating system packages..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq && apt-get upgrade -y -qq
apt-get install -y -qq ca-certificates curl gnupg lsb-release ufw git openssl

log "Step 2/9: Creating 2GB swap file (Crucial for 1GB RAM)..."
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

log "Step 3/9: Installing Docker..."
if ! command -v docker &>/dev/null; then
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    chmod a+r /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(. /etc/os-release && echo "$VERSION_CODENAME") stable" \
        > /etc/apt/sources.list.d/docker.list
    apt-get update -qq
    apt-get install -y -qq docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
    systemctl enable docker && systemctl start docker
    log "  → Docker installed"
else
    log "  → Docker already installed, skipping"
fi

log "Step 4/9: Creating deploy user..."
if ! id -u "$DEPLOY_USER" &>/dev/null; then
    useradd -m -s /bin/bash "$DEPLOY_USER"
    usermod -aG docker "$DEPLOY_USER"
    echo "$DEPLOY_USER ALL=(ALL) NOPASSWD: /usr/bin/docker, /usr/bin/docker-compose, /usr/bin/make" > /etc/sudoers.d/deploy-docker
    chmod 0440 /etc/sudoers.d/deploy-docker
    log "  → Created user '$DEPLOY_USER'"
else
    log "  → User '$DEPLOY_USER' already exists, skipping"
fi

log "Step 5/9: Configuring UFW firewall..."
ufw default deny incoming >/dev/null
ufw default allow outgoing >/dev/null
ufw allow 22/tcp  >/dev/null
ufw allow 80/tcp  >/dev/null
ufw --force enable >/dev/null
log "  → Firewall enabled (ports 22, 80 open)"

log "Step 6/9: Cloning repo to $APP_DIR..."
if [[ ! -d "$APP_DIR" ]]; then
    git clone "$REPO_URL" "$APP_DIR"
    log "  → Repo cloned"
else
    log "  → Repo already exists, resetting to main..."
    cd "$APP_DIR"
    git fetch origin
    git reset --hard origin/main
fi

log "Step 7/9: Setting up Single Source of Truth .env..."
cd "$APP_DIR"
PUBLIC_IP=$(curl -fsSL -4 ifconfig.me 2>/dev/null || echo "YOUR_DROPLET_IP")

if [[ ! -f "src/.env" ]]; then
    cp src/.env.production.example src/.env
    DB_PASSWORD=$(openssl rand -hex 16)
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD|" src/.env
    sed -i "s|^APP_URL=.*|APP_URL=http://$PUBLIC_IP|" src/.env
    log "  → Generated new src/.env file with DB_PASSWORD and IP."
else
    log "  → src/.env already exists. Preserving existing configurations."
fi

chown "$DEPLOY_USER:$DEPLOY_USER" src/.env
chmod 600 src/.env

log "Step 8/9: Building dependencies (Composer & NPM via Docker)..."
docker run --rm -v "$APP_DIR/src:/app" -w /app composer:latest install --ignore-platform-reqs --optimize-autoloader --no-dev
docker run --rm -v "$APP_DIR/src:/app" -w /app node:20-alpine sh -c "npm install && npm run build"

chown -R "$DEPLOY_USER:$DEPLOY_USER" "$APP_DIR"
log "  → Vendor and public/build directories generated & secured."

log "Step 9/9: Building and starting containers..."
DC_CMD="docker compose --env-file src/.env -f docker-compose.prod.yml"

sudo -u "$DEPLOY_USER" $DC_CMD up -d --build

log "Waiting 15s for Postgres to initialize..."
sleep 15

log "Running Laravel setup (key, migrate, storage link, cache)..."
sudo -u "$DEPLOY_USER" $DC_CMD exec -T app php artisan key:generate --force
sudo -u "$DEPLOY_USER" $DC_CMD exec -T app php artisan migrate --force
sudo -u "$DEPLOY_USER" $DC_CMD exec -T app php artisan db:seed --force
sudo -u "$DEPLOY_USER" $DC_CMD exec -T app php artisan storage:link
sudo -u "$DEPLOY_USER" $DC_CMD exec -T app php artisan optimize

echo ""
echo "═══════════════════════════════════════════════════════════"
log "BOOTSTRAP COMPLETE"
echo "═══════════════════════════════════════════════════════════"
echo "  Visit:     http://$PUBLIC_IP"
echo "  SSH user:  $DEPLOY_USER"
echo "  Command:   cd $APP_DIR && make prod-status"
echo "═══════════════════════════════════════════════════════════"
