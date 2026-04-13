# ==============================================================================
# MyLinx - Cross-Platform Development Toolkit
# Detects UID/GID dynamically (falls back to 1000 for Windows)
# ==============================================================================

# --------------------------------------------------------------------------
# Cross-platform UID/GID detection
# On Linux/macOS: uses actual user IDs
# On Windows (Git Bash/WSL): defaults to 1000
# --------------------------------------------------------------------------
UID := $(shell id -u 2>/dev/null || echo 1000)
GID := $(shell id -g 2>/dev/null || echo 1000)

# --------------------------------------------------------------------------
# Docker Compose command
# --------------------------------------------------------------------------
DC := docker compose
APP := $(DC) exec -u www-data app
APP_ROOT := $(DC) exec app

# Export for docker-compose.yml interpolation
export UID
export GID

# ==============================================================================
# Container Lifecycle
# ==============================================================================

.PHONY: build up down restart status logs

## Build all containers (passes UID/GID for permission mapping)
build:
	$(DC) build --build-arg UID=$(UID) --build-arg GID=$(GID)

## Start all containers in detached mode
up:
	$(DC) up -d

## Stop and remove all containers
down:
	$(DC) down

## Restart all containers
restart: down up

## Show container status
status:
	$(DC) ps

## Tail logs from all containers
logs:
	$(DC) logs -f

## Tail logs from the app container only
logs-app:
	$(DC) logs -f app

# ==============================================================================
# Shell Access
# ==============================================================================

.PHONY: shell shell-root

## Open a bash shell in the app container as www-data
shell:
	$(APP) bash

## Open a bash shell in the app container as root (for installing packages)
shell-root:
	$(APP_ROOT) bash

# ==============================================================================
# Dependency Management
# ==============================================================================

.PHONY: install composer-install npm-install

## Install ALL dependencies (Composer + NPM)
install: composer-install npm-install

## Install PHP dependencies via Composer
composer-install:
	$(APP) composer install

## Install Node.js dependencies via NPM
npm-install:
	$(APP) npm install

## Update Composer dependencies
composer-update:
	$(APP) composer update

# ==============================================================================
# Laravel Artisan Commands
# ==============================================================================

.PHONY: migrate migrate-fresh seed tinker optimize-clear key-generate

## Run database migrations
migrate:
	$(APP) php artisan migrate

## Fresh migration + seed (DESTRUCTIVE - resets entire DB)
migrate-fresh:
	$(APP) php artisan migrate:fresh --seed

## Run database seeders
seed:
	$(APP) php artisan db:seed

## Open Laravel Tinker REPL
tinker:
	$(APP) php artisan tinker

## Clear all Laravel caches (config, route, view, event, cache)
optimize-clear:
	$(APP) php artisan optimize:clear

## Generate application key
key-generate:
	$(APP) php artisan key:generate

## Create a storage symlink
storage-link:
	$(APP) php artisan storage:link

# ==============================================================================
# Frontend Assets
# ==============================================================================

.PHONY: dev build-assets

## Run Vite dev server (hot-reload)
dev:
	$(APP) npm run dev

## Build frontend assets for production
build-assets:
	$(APP) npm run build

# ==============================================================================
# Code Quality & Testing
# ==============================================================================

.PHONY: test lint

## Run PHPUnit tests
test:
	$(APP) php artisan test

## Run Pint (Laravel code style fixer)
lint:
	$(APP) ./vendor/bin/pint

# ==============================================================================
# Utility
# ==============================================================================

.PHONY: fresh-start

## Full reset: rebuild containers, install deps, fresh migrate
fresh-start: down build up install migrate-fresh
	@echo ""
	@echo "============================================"
	@echo "  MyLinx is ready! Visit http://localhost:8000"
	@echo "============================================"

## Show all available commands
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
