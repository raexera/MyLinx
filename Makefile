UID := $(shell id -u 2>/dev/null || echo 1000)
GID := $(shell id -g 2>/dev/null || echo 1000)

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
