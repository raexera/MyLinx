# MyLinx

Multi-tenant SaaS Web Generator for MSMEs (UMKM).

## Project Structure

```
MyLinx/
├── Dockerfile              # PHP 8.3 FPM + Node.js + Composer
├── docker-compose.yml      # app (PHP-FPM) + web (Nginx) + db (PostgreSQL)
├── Makefile                # All developer commands
├── .dockerignore
├── .gitignore
├── docker/
│   └── nginx/
│       └── default.conf    # Nginx → PHP-FPM config
└── src/                    # ← Laravel application lives here
    ├── app/
    ├── config/
    ├── routes/
    ├── ...
    └── .env
```

> **Root** = infrastructure only. **`src/`** = all Laravel code.

## Prerequisites

- **Docker** & **Docker Compose** v2+
- **Make** (pre-installed on Linux/macOS; available via Git Bash or WSL2 on Windows)

## Quick Start

```bash
# 1. Clone the repo
git clone <repo-url> mylinx && cd mylinx

# 2. Bootstrap everything (scaffolds Laravel into src/, installs all packages, builds assets)
make init

# 3. Run database migrations
make migrate

# 4. Open http://localhost:8080
```

## Daily Workflow

```bash
make up            # Start containers
make down          # Stop containers
make shell         # Shell into the app container (inside src/)
make tinker        # Laravel Tinker REPL
make migrate       # Run migrations
make seed          # Run seeders
make npm-dev       # Vite HMR dev server
make npm-build     # Production asset build
make lint          # Laravel Pint code style
make test          # Run tests
make logs          # Tail all container logs
make help          # Show all commands
```

## Architecture

| Component  | Technology                                     |
| ---------- | ---------------------------------------------- |
| Framework  | Laravel (latest)                               |
| Frontend   | Blade + TailwindCSS                            |
| Web Server | Nginx                                          |
| PHP        | 8.3 FPM (Alpine)                               |
| Database   | PostgreSQL 16                                  |
| Tenancy    | Single DB / Shared Schema (`tenant_id` column) |

## Ports

| Service | Host Port | Override        |
| ------- | --------- | --------------- |
| Web     | 8080      | `APP_PORT=9000` |
| DB      | 5432      | `DB_PORT=5433`  |
