#!/usr/bin/env bash

set -uo pipefail

REPO_URL="https://github.com/raexera/MyLinx.git"
APP_DIR="/opt/mylinx"

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log()  { echo -e "${GREEN}[bootstrap]${NC} $*"; }
warn() { echo -e "${YELLOW}[bootstrap]${NC} $*"; }
err()  { echo -e "${RED}[bootstrap ERROR]${NC} $*" >&2; exit 1; }
ok()   { echo -e "${GREEN}[bootstrap ✓]${NC} $*"; }

must() {
    "$@"
    local rc=$?
    if [[ $rc -ne 0 ]]; then
        err "Command failed (exit $rc): $*"
    fi
}

[[ $EUID -eq 0 ]] || err "Must run as root. Try: sudo bash bootstrap.sh"

log "Step 1/11: Updating system packages..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get upgrade -y -qq
apt-get install -y -qq ca-certificates curl gnupg lsb-release ufw git openssl make

log "Step 2/11: Ensuring 2GB swap file exists..."
if [[ ! -f /swapfile ]]; then
    fallocate -l 2G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile >/dev/null
    swapon /swapfile
    echo '/swapfile none swap sw 0 0' >> /etc/fstab
    ok "  2GB swap created"
else
    log "  → Swap already exists"
fi

log "Step 3/11: Installing Docker..."
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
    ok "  Docker installed"
else
    log "  → Docker already installed"
fi

log "Step 4/11: Configuring UFW firewall..."
ufw default deny incoming >/dev/null
ufw default allow outgoing >/dev/null
ufw allow 22/tcp  >/dev/null
ufw allow 80/tcp  >/dev/null
ufw --force enable >/dev/null
ok "  Firewall enabled (ports 22, 80)"

log "Step 5/11: Cloning MyLinx repo..."
if [[ ! -d "$APP_DIR/.git" ]]; then
    must git clone "$REPO_URL" "$APP_DIR"
    ok "  Repo cloned to $APP_DIR"
else
    log "  → Repo exists, pulling latest from main..."
    cd "$APP_DIR"
    must git fetch origin
    must git reset --hard origin/main
fi

cd "$APP_DIR"

log "Step 6/11: Creating src/.env with APP_KEY pre-generated..."
PUBLIC_IP=$(curl -fsSL -4 ifconfig.me 2>/dev/null || echo "YOUR_DROPLET_IP")

if [[ ! -f "src/.env" ]]; then
    cp src/.env.production.example src/.env
    DB_PASSWORD=$(openssl rand -hex 16)
    APP_KEY="base64:$(openssl rand -base64 32)"

    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" src/.env
    sed -i "s|^APP_URL=.*|APP_URL=http://${PUBLIC_IP}|" src/.env
    sed -i "s@^APP_KEY=.*@APP_KEY=${APP_KEY}@" src/.env

    ok "  Generated src/.env"
    log "    APP_URL:     http://${PUBLIC_IP}"
    log "    DB_PASSWORD: (random 32 hex chars)"
    log "    APP_KEY:     base64:(random 32 bytes)"
else
    log "  → src/.env already exists, preserving"

    if ! grep -q "^APP_KEY=base64:" src/.env; then
        APP_KEY="base64:$(openssl rand -base64 32)"
        sed -i "s@^APP_KEY=.*@APP_KEY=${APP_KEY}@" src/.env
        warn "    APP_KEY was empty, generated new key"
    fi
fi

chown 1000:1000 src/.env
chmod 600 src/.env

log "  → Validating env config..."
for key in APP_KEY APP_URL DB_DATABASE DB_USERNAME DB_PASSWORD; do
    value=$(grep "^${key}=" src/.env | cut -d= -f2-)
    if [[ -z "$value" ]]; then
        err "Required env key is empty: $key"
    fi
done
ok "  All required env keys are set"

log "Step 7/11: Installing Composer dependencies (~2 min)..."
must docker run --rm \
    -v "$APP_DIR/src:/app" \
    -w /app \
    composer:latest \
    install --no-dev --optimize-autoloader --no-interaction --no-progress \
    --ignore-platform-req=ext-pgsql --ignore-platform-req=ext-pdo_pgsql

[[ -f "$APP_DIR/src/vendor/autoload.php" ]] || err "vendor/autoload.php missing after composer install"
ok "  Composer install complete, vendor/autoload.php verified"

log "Step 8/11: Installing NPM dependencies + building assets (~3 min)..."
must docker run --rm \
    -v "$APP_DIR/src:/app" \
    -w /app \
    node:20-bookworm-slim \
    sh -c "npm ci --no-audit --no-fund && npm run build"

[[ -f "$APP_DIR/src/public/build/manifest.json" ]] || err "public/build/manifest.json missing after npm build"
ok "  NPM build complete, manifest.json verified"

log "  → Fixing ownership to 1000:1000 (matches container's www-data)..."
chown -R 1000:1000 "$APP_DIR/src"

log "Step 9/11: Clearing stale Laravel caches..."
rm -f "$APP_DIR/src/bootstrap/cache/config.php"
rm -f "$APP_DIR/src/bootstrap/cache/routes-v7.php"
rm -f "$APP_DIR/src/bootstrap/cache/packages.php"
rm -f "$APP_DIR/src/bootstrap/cache/services.php"
find "$APP_DIR/src/storage/framework/views" -name "*.php" -type f -delete 2>/dev/null || true
ok "  Compiled caches cleared"

log "Step 10/11: Building and starting containers..."
DC="docker compose --env-file src/.env -f docker-compose.prod.yml"

must $DC build
must $DC up -d --force-recreate

log "  → Waiting 25s for containers to fully initialize..."
sleep 25

log "  → Verifying container health..."
for svc in db app web; do
    if ! $DC ps --format json 2>/dev/null | grep -q "\"Service\":\"$svc\".*\"State\":\"running\""; then
        # Fallback check if json format differs
        state=$($DC ps --services --filter "status=running" | grep -c "^$svc$" || echo "0")
        if [[ "$state" -eq 0 ]]; then
            err "Container '$svc' is not running. Check: $DC logs $svc"
        fi
    fi
done
ok "  All containers running"

log "  → Reconciling storage permissions (non-fatal)..."
$DC exec -T -u root app sh -c "chown -R www-data:www-data /var/www/html/storage 2>/dev/null; chmod -R 775 /var/www/html/storage 2>/dev/null; true"
ok "  Storage permissions reconciled"

log "Step 11/11: Running Laravel setup..."

log "  → Running migrations..."
must $DC exec -T app php artisan migrate --force
ok "  Migrations complete"

log "  → Seeding database..."
must $DC exec -T app php artisan db:seed --force
ok "  Database seeded"

log "  → Creating storage symlink..."
$DC exec -T app php artisan storage:link 2>/dev/null || true
ok "  Storage symlink handled"

log "  → Caching config..."
must $DC exec -T app php artisan config:cache
ok "  Config cached"

log "  → Caching routes..."
must $DC exec -T app php artisan route:cache
ok "  Routes cached"

log "  → Caching views..."
must $DC exec -T app php artisan view:cache
ok "  Views cached"

log "  → Running HTTP sanity check..."
sleep 3
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost || echo "000")

if [[ "$HTTP_STATUS" == "200" ]] || [[ "$HTTP_STATUS" == "302" ]]; then
    ok "  Site responding: HTTP $HTTP_STATUS"
else
    warn "  Site returned HTTP $HTTP_STATUS (expected 200 or 302)"
    warn "  Check logs with:"
    warn "    cd $APP_DIR && make prod-logs"
    warn "    $DC exec -T app tail -50 storage/logs/laravel.log"
fi

echo ""
echo "═══════════════════════════════════════════════════════════"
ok "BOOTSTRAP COMPLETE"
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
