# MyLinx

### Commands Cheatsheet

| Command               | What it does                                     |
| --------------------- | ------------------------------------------------ |
| `make up`             | Start all containers (detached)                  |
| `make down`           | Stop all containers                              |
| `make shell`          | Bash into app container as `www-data`            |
| `make shell-root`     | Bash into app container as `root`                |
| `make install`        | Run `composer install` + `npm install`           |
| `make migrate`        | Run `php artisan migrate`                        |
| `make migrate-fresh`  | Reset DB + re-seed (`migrate:fresh --seed`)      |
| `make dev`            | Start Vite dev server (hot-reload for Tailwind)  |
| `make build-assets`   | Build frontend for production                    |
| `make tinker`         | Open Laravel Tinker REPL                         |
| `make optimize-clear` | Clear all Laravel caches                         |
| `make test`           | Run PHPUnit tests                                |
| `make lint`           | Run Laravel Pint code formatter                  |
| `make logs`           | Tail all container logs                          |
| `make fresh-start`    | Full nuclear reset (rebuild + install + migrate) |
| `make help`           | Show all available commands                      |
