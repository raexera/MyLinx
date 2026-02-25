# =============================================================================
# MyLinx – Developer Makefile (cross-platform: Linux / macOS / WSL2 / Git Bash)
# =============================================================================
#
# Project layout:
#   ./                  → Docker & infra files only
#   ./src/              → Laravel application code (mounted to /var/www/html)
#   ./docker/           → Nginx config, etc.
#
# =============================================================================

export UID ?= $(shell id -u 2>/dev/null || echo 1000)
export GID ?= $(shell id -g 2>/dev/null || echo 1000)

DOCKER_COMPOSE = docker compose
EXEC_APP       = $(DOCKER_COMPOSE) exec app
EXEC_APP_ROOT  = $(DOCKER_COMPOSE) exec -u root app
RUN_APP        = $(DOCKER_COMPOSE) run --rm --no-deps app
ARTISAN        = $(EXEC_APP) php artisan

# Laravel source directory on the host
SRC_DIR        = src

.DEFAULT_GOAL := help

# =============================================================================
# 🚀  First-Time Bootstrap
# =============================================================================

## init            : Scaffold a fresh Laravel project into src/ and install all packages
.PHONY: init
init: _ensure-src _build _create-project _install-packages _env _up-wait _publish-vendors _key _npm-install _npm-build
	@echo ""
	@echo "============================================"
	@echo "  MyLinx initialised!"
	@echo "  Run: make migrate"
	@echo "  Then open http://localhost:8080"
	@echo "============================================"

## setup           : Install deps, generate key, run migrations, build assets (post-clone)
.PHONY: setup
setup: _env _up-wait _composer-install _npm-install _key _migrate _npm-build
	@echo ""
	@echo "============================================"
	@echo "  Setup complete!"
	@echo "============================================"

# =============================================================================
# 🐳  Container Lifecycle
# =============================================================================

## up              : Start all containers in detached mode
.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

## down            : Stop and remove all containers
.PHONY: down
down:
	$(DOCKER_COMPOSE) down

## restart         : Restart all containers
.PHONY: restart
restart:
	$(DOCKER_COMPOSE) restart

## build           : Rebuild container images (no cache)
.PHONY: build
build:
	$(DOCKER_COMPOSE) build --no-cache --build-arg UID=$(UID) --build-arg GID=$(GID)

## logs            : Tail logs from all containers
.PHONY: logs
logs:
	$(DOCKER_COMPOSE) logs -f

## ps              : Show running containers
.PHONY: ps
ps:
	$(DOCKER_COMPOSE) ps

# =============================================================================
# 🔧  Development Shortcuts
# =============================================================================

## shell           : Open a shell inside the app container
.PHONY: shell
shell:
	$(EXEC_APP) bash

## shell-root      : Open a root shell inside the app container
.PHONY: shell-root
shell-root:
	$(EXEC_APP_ROOT) bash

## tinker          : Open Laravel Tinker REPL
.PHONY: tinker
tinker:
	$(ARTISAN) tinker

## artisan         : Run any artisan command – usage: make artisan CMD="route:list"
.PHONY: artisan
artisan:
	$(ARTISAN) $(CMD)

## composer        : Run any composer command – usage: make composer CMD="require foo/bar"
.PHONY: composer
composer:
	$(EXEC_APP) composer $(CMD)

# =============================================================================
# 🗄️  Database
# =============================================================================

## migrate         : Run database migrations
.PHONY: migrate
migrate:
	$(ARTISAN) migrate

## migrate-fresh   : Drop all tables and re-run migrations
.PHONY: migrate-fresh
migrate-fresh:
	$(ARTISAN) migrate:fresh

## seed            : Run database seeders
.PHONY: seed
seed:
	$(ARTISAN) db:seed

## fresh-seed      : Fresh migration + seed
.PHONY: fresh-seed
fresh-seed:
	$(ARTISAN) migrate:fresh --seed

# =============================================================================
# 🎨  Frontend Assets
# =============================================================================

## npm-dev         : Run Vite dev server (HMR)
.PHONY: npm-dev
npm-dev:
	$(EXEC_APP) npm run dev

## npm-build       : Build production assets
.PHONY: npm-build
npm-build:
	$(EXEC_APP) npm run build

## npm-install     : Install NPM dependencies
.PHONY: npm-install
npm-install:
	$(EXEC_APP) npm install

# =============================================================================
# 🧹  Code Quality
# =============================================================================

## lint            : Run Laravel Pint (code style fixer)
.PHONY: lint
lint:
	$(EXEC_APP) ./vendor/bin/pint

## test            : Run the test suite
.PHONY: test
test:
	$(ARTISAN) test

# =============================================================================
# 🧹  Cleanup
# =============================================================================

## clean           : Stop containers, remove volumes (⚠️  destroys DB data)
.PHONY: clean
clean:
	$(DOCKER_COMPOSE) down -v --remove-orphans
	@echo "Volumes removed. Database data destroyed."

# =============================================================================
# 📖  Help
# =============================================================================

## help            : Show this help message
.PHONY: help
help:
	@echo ""
	@echo "  MyLinx – available commands"
	@echo "  =========================="
	@echo ""
	@grep -E '^##' $(MAKEFILE_LIST) | sed 's/^## /  /'
	@echo ""

# =============================================================================
# 🔒  Internal Targets (prefixed with _)
# =============================================================================

.PHONY: _ensure-src
_ensure-src:
	@mkdir -p $(SRC_DIR)

.PHONY: _build
_build:
	$(DOCKER_COMPOSE) build --build-arg UID=$(UID) --build-arg GID=$(GID)

.PHONY: _create-project
_create-project:
	@echo ">>> Scaffolding Laravel into $(SRC_DIR)/..."
	$(DOCKER_COMPOSE) run --rm --no-deps -u root app sh -c "\
		chown -R www-data:www-data /var/www/html && \
		su www-data -c 'composer create-project laravel/laravel /tmp/laravel-fresh --prefer-dist' && \
		su www-data -c 'cp -a /tmp/laravel-fresh/. /var/www/html/' && \
		rm -rf /tmp/laravel-fresh \
	"
	@echo ">>> Laravel scaffolded into $(SRC_DIR)/."

.PHONY: _install-packages
_install-packages:
	@echo ">>> Installing required Composer packages..."
	$(RUN_APP) composer require \
		stancl/tenancy \
		simplesoftwareio/simple-qrcode \
		spatie/laravel-activitylog \
		spatie/laravel-permission \
		spatie/laravel-query-builder \
		spatie/laravel-medialibrary \
		intervention/image-laravel
	$(RUN_APP) composer require --dev \
		laravel/pint \
		laravel/breeze
	@echo ">>> All Composer packages installed."

.PHONY: _publish-vendors
_publish-vendors:
	@echo ">>> Publishing vendor files & installing Breeze (Blade)..."
	$(ARTISAN) breeze:install blade --no-interaction
	$(ARTISAN) tenancy:install
	$(ARTISAN) vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
	$(ARTISAN) vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
	$(ARTISAN) vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
	$(ARTISAN) vendor:publish --provider="Intervention\Image\ImageServiceProvider" 2>/dev/null || true
	@echo ">>> Vendor files published."

.PHONY: _env
_env:
	@if [ ! -f $(SRC_DIR)/.env ]; then \
		cp $(SRC_DIR)/.env.example $(SRC_DIR)/.env 2>/dev/null || true; \
		echo ">>> .env created from .env.example"; \
	fi
	@# Patch DB settings for Docker PostgreSQL
	@if grep -q "DB_CONNECTION=sqlite" $(SRC_DIR)/.env 2>/dev/null; then \
		sed -i.bak 's/DB_CONNECTION=sqlite/DB_CONNECTION=pgsql/' $(SRC_DIR)/.env && rm -f $(SRC_DIR)/.env.bak; \
		sed -i.bak 's/# DB_HOST=127.0.0.1/DB_HOST=db/' $(SRC_DIR)/.env && rm -f $(SRC_DIR)/.env.bak; \
		sed -i.bak 's/# DB_PORT=3306/DB_PORT=5432/' $(SRC_DIR)/.env && rm -f $(SRC_DIR)/.env.bak; \
		sed -i.bak 's/# DB_DATABASE=laravel/DB_DATABASE=mylinx/' $(SRC_DIR)/.env && rm -f $(SRC_DIR)/.env.bak; \
		sed -i.bak 's/# DB_USERNAME=root/DB_USERNAME=mylinx/' $(SRC_DIR)/.env && rm -f $(SRC_DIR)/.env.bak; \
		sed -i.bak 's/# DB_PASSWORD=/DB_PASSWORD=secret/' $(SRC_DIR)/.env && rm -f $(SRC_DIR)/.env.bak; \
		echo ">>> .env patched for PostgreSQL (Docker)"; \
	fi

.PHONY: _key
_key:
	$(ARTISAN) key:generate

.PHONY: _up-wait
_up-wait:
	$(DOCKER_COMPOSE) up -d
	@echo ">>> Waiting for services to be ready..."
	@sleep 5

.PHONY: _composer-install
_composer-install:
	$(EXEC_APP) composer install

.PHONY: _npm-install
_npm-install:
	$(EXEC_APP) npm install

.PHONY: _npm-build
_npm-build:
	$(EXEC_APP) npm run build

.PHONY: _migrate
_migrate:
	$(ARTISAN) migrate --force
