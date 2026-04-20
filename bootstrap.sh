#!/usr/bin/env bash

set -euo pipefail

REPO_URL="https://github.com/raexera/MyLinx.git"
APP_DIR="/opt/mylinx"

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log()  { echo -e "${GREEN}[bootstrap]${NC} $*"; }
warn() { echo -e "${YELLOW}[bootstrap]${NC} $*"; }
err()  { echo -e "${RED}[bootstrap]${NC} $*"; exit 1; }

[[ $EUID -eq 0 ]] || err "Must run as root. Try: sudo bash bootstrap.sh"

log "Step 1/10: Updating system packages..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get upgrade -y -qq
apt-get install -y -qq ca-certificates curl gnupg lsb-release ufw git openssl make

log "Step 2/10: Ensuring 2GB swap file exists..."
if [[ ! -f /swapfile ]]; then
    fallocate -l 2G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile >/dev/null
    swapon /swapfile
    echo '/swapfile none swap sw 0 0' >> /etc/fstab
    log "  → 2GB swap created"
else
    log "  → Swap already exists"
fi

log "Step 3/10: Installing Docker..."
if ! command -v docker &>/dev/null; then
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | \
        gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    chmod a+r /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(. /etc/os-release && echo "$VERSION_CODENAME") stable" \
        > /etc/apt/sources.list.d/docker.list
    apt-get update -qq
    apt-get install -y -qq \
        docker-ce docker-ce-cli containerd.io \
        docker-buildx-plugin docker-compose-plugin
    systemctl enable docker
    systemctl start docker
    log "  → Docker installed"
else
    log "  → Docker already installed"
fi

log "Step 4/10: Configuring UFW firewall..."
ufw default deny incoming >/dev/null
ufw default allow outgoing >/dev/null
ufw allow 22/tcp  >/dev/null
ufw allow 80/tcp  >/dev/null
ufw --force enable >/dev/null
log "  → Firewall enabled (ports 22, 80)"

log "Step 5/10: Cloning MyLinx repo..."
if [[ ! -d "$APP_DIR/.git" ]]; then
    git clone "$REPO_URL" "$APP_DIR"
    log "  → Repo cloned to $APP_DIR"
else
    log "  → Repo exists, pulling latest from main..."
    cd "$APP_DIR"
    git fetch origin
    git reset --hard origin/main
fi

cd "$APP_DIR"

log "Step 6/10: Creating src/.env..."
PUBLIC_IP=$(curl -fsSL -4 ifconfig.me 2>/dev/null || echo "YOUR_DROPLET_IP")

if [[ ! -f "src/.env" ]]; then
    cp src/.env.production.example src/.env
    DB_PASSWORD=$(openssl rand -hex 16)
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" src/.env
    sed -i "s|^APP_URL=.*|APP_URL=http://${PUBLIC_IP}|" src/.env
    log "  → Generated src/.env (DB_PASSWORD randomized, APP_URL=http://${PUBLIC_IP})"
else
    log "  → src/.env already exists, preserving"
fi
chmod 600 src/.env

log "  → DB config from src/.env:"
grep -E '^(DB_DATABASE|DB_USERNAME|APP_URL)' src/.env | sed 's/^/       /'

log "Step 7/10: Installing Composer dependencies (this takes ~2 min)..."
docker run --rm \
    -v "$APP_DIR/src:/app" \
    -w /app \
    composer:latest \
    install --no-dev --optimize-autoloader --no-interaction --no-progress \
    --ignore-platform-req=ext-pgsql --ignore-platform-req=ext-pdo_pgsql

log "Step 8/10: Installing NPM dependencies + building assets (this takes ~3 min)..."
docker run --rm \
    -v "$APP_DIR/src:/app" \
    -w /app \
    node:20-bookworm-slim \
    sh -c "npm ci --no-audit --no-fund && npm run build"

log "  → Fixing file ownership to 1000:1000 (matches container's www-data)..."
chown -R 1000:1000 "$APP_DIR/src/vendor" "$APP_DIR/src/public/build" "$APP_DIR/src/node_modules" 2>/dev/null || true

log "Step 9/10: Building and starting containers..."
DC="docker compose --env-file src/.env -f docker-compose.prod.yml"

$DC build
$DC up -d

log "  → Waiting 20s for Postgres to initialize..."
sleep 20

log "Step 10/10: Running Laravel setup..."
$DC exec -T app php artisan key:generate --force
$DC exec -T app php artisan migrate --force
$DC exec -T app php artisan db:seed --force
$DC exec -T app php artisan storage:link
$DC exec -T app php artisan config:cache
$DC exec -T app php artisan route:cache
$DC exec -T app php artisan view:cache

echo ""
echo "═══════════════════════════════════════════════════════════"
log "BOOTSTRAP COMPLETE"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "  Visit:      http://${PUBLIC_IP}"
echo "  SSH:        ssh root@${PUBLIC_IP}"
echo "  App dir:    ${APP_DIR}"
echo ""
echo "  Test accounts:"
echo "    admin@tokobaju.test / password"
echo "    superadmin@mylinx.test / password"
echo ""
echo "  Useful commands (run from ${APP_DIR}):"
echo "    make prod-status      # container health"
echo "    make prod-logs        # tail logs"
echo "    make prod-shell       # enter PHP container"
echo "    make prod-deploy      # pull + rebuild + migrate"
echo ""
echo "═══════════════════════════════════════════════════════════"
