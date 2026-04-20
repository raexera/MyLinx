UID := $(shell id -u 2>/dev/null || echo 1000)
GID := $(shell id -g 2>/dev/null || echo 1000)

# =══════════════════════════════════════════════════════════
# DEVELOPMENT TARGETS
# =══════════════════════════════════════════════════════════
DC := docker compose
APP := $(DC) exec -u www-data app
APP_ROOT := $(DC) exec app

export UID
export GID

.PHONY: build up down restart status logs

build:
	$(DC) build --build-arg UID=$(UID) --build-arg GID=$(GID)

up:
	$(DC) up -d

down:
	$(DC) down

restart: down up

status:
	$(DC) ps

logs:
	$(DC) logs -f

logs-app:
	$(DC) logs -f app

.PHONY: shell shell-root

shell:
	$(APP) bash

shell-root:
	$(APP_ROOT) bash

.PHONY: install composer-install npm-install

install: composer-install npm-install

composer-install:
	$(APP) composer install

npm-install:
	$(APP) npm install

composer-update:
	$(APP) composer update

.PHONY: migrate migrate-fresh seed tinker optimize-clear key-generate

migrate:
	$(APP) php artisan migrate

migrate-fresh:
	$(APP) php artisan migrate:fresh --seed

seed:
	$(APP) php artisan db:seed

tinker:
	$(APP) php artisan tinker

optimize-clear:
	$(APP) php artisan optimize:clear

key-generate:
	$(APP) php artisan key:generate

storage-link:
	$(APP) php artisan storage:link

.PHONY: dev build-assets

dev:
	$(APP) npm run dev

build-assets:
	$(APP) npm run build

.PHONY: test lint lint-html

test:
	$(APP) php artisan test

lint:
	$(APP) ./vendor/bin/pint

lint-html:
	$(APP) npx prettier --write "resources/views/**/*.blade.php"

.PHONY: fresh-start

fresh-start: down build up install migrate-fresh
	@echo ""
	@echo "============================================"
	@echo "  MyLinx is ready! Visit http://localhost:8000"
	@echo "============================================"

help:
	@echo ""
	@echo "  MyLinx Development Toolkit"
	@echo "  =========================="
	@echo ""
	@echo "  LIFECYCLE:"
	@echo "    make build          - Build containers (with UID/GID mapping)"
	@echo "    make up             - Start containers (detached)"
	@echo "    make down           - Stop containers"
	@echo "    make restart        - Restart containers"
	@echo "    make status         - Show container status"
	@echo "    make logs           - Tail all container logs"
	@echo ""
	@echo "  SHELL:"
	@echo "    make shell          - Bash as www-data"
	@echo "    make shell-root     - Bash as root"
	@echo ""
	@echo "  DEPENDENCIES:"
	@echo "    make install        - Install Composer + NPM deps"
	@echo "    make composer-install"
	@echo "    make npm-install"
	@echo ""
	@echo "  LARAVEL:"
	@echo "    make migrate        - Run migrations"
	@echo "    make migrate-fresh  - Fresh migrate + seed (DESTRUCTIVE)"
	@echo "    make seed           - Run seeders"
	@echo "    make tinker         - Open Tinker REPL"
	@echo "    make optimize-clear - Clear all caches"
	@echo "    make key-generate   - Generate app key"
	@echo "    make storage-link   - Create storage symlink"
	@echo ""
	@echo "  FRONTEND:"
	@echo "    make dev            - Vite dev server (hot-reload)"
	@echo "    make build-assets   - Build for production"
	@echo ""
	@echo "  TESTING:"
	@echo "    make test           - Run PHPUnit tests"
	@echo "    make lint           - Run Laravel Pint"
	@echo ""
	@echo "  COMBO:"
	@echo "    make fresh-start    - Full reset (rebuild + install + migrate)"
	@echo ""

# ═══════════════════════════════════════════════════════════
# PRODUCTION TARGETS
# ═══════════════════════════════════════════════════════════

DC_PROD := docker compose --env-file ./src/.env -f docker-compose.prod.yml
APP_PROD := $(DC_PROD) exec app

.PHONY: prod-build prod-up prod-down prod-restart prod-logs prod-shell prod-status
.PHONY: prod-deploy prod-migrate prod-cache-clear prod-cache-warm
.PHONY: prod-db-backup prod-db-restore

prod-build:
	$(DC_PROD) build

prod-up:
	$(DC_PROD) up -d

prod-down:
	$(DC_PROD) down

prod-restart:
	$(DC_PROD) restart

prod-status:
	$(DC_PROD) ps

prod-logs:
	$(DC_PROD) logs -f --tail=100

prod-shell:
	$(APP_PROD) bash

prod-deploy:
	@echo "→ Pulling latest code from git..."
	git pull origin main
	@echo "→ Rebuilding containers..."
	$(DC_PROD) build
	@echo "→ Restarting services..."
	$(DC_PROD) up -d
	@echo "→ Waiting for db..."
	@sleep 5
	@echo "→ Running migrations..."
	$(APP_PROD) php artisan migrate --force
	@echo "→ Warming caches..."
	$(APP_PROD) php artisan config:cache
	$(APP_PROD) php artisan route:cache
	$(APP_PROD) php artisan view:cache
	@echo ""
	@echo "✓ Deploy complete."

prod-migrate:
	$(APP_PROD) php artisan migrate --force

prod-cache-clear:
	$(APP_PROD) php artisan optimize:clear

prod-cache-warm:
	$(APP_PROD) php artisan config:cache
	$(APP_PROD) php artisan route:cache
	$(APP_PROD) php artisan view:cache

prod-db-backup:
	@mkdir -p backups
	@TS=$$(date +%Y-%m-%d-%H%M%S); \
	$(DC_PROD) exec -T db pg_dump -U mylinx mylinx > backups/$$TS.sql && \
	echo "✓ Backup saved to backups/$$TS.sql"

prod-db-restore:
	@if [ -z "$(FILE)" ]; then echo "Usage: make prod-db-restore FILE=path/to/backup.sql"; exit 1; fi
	@echo "⚠ This will OVERWRITE the production database."
	@echo "   Restoring from: $(FILE)"
	@read -p "   Type YES to continue: " confirm; [ "$$confirm" = "YES" ] || exit 1
	cat $(FILE) | $(DC_PROD) exec -T db psql -U mylinx mylinx
	@echo "✓ Restore complete."
