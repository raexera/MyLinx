# MyLinx Installation Guide

This document outlines the installation and deployment process using Docker and Make.

## Prerequisites

- Git
- Docker & Docker Compose (v2)
- GNU Make

---

## Local Development Setup

**1. Clone and Configure**

```bash
git clone https://github.com/raexera/MyLinx.git
cd MyLinx
cp src/.env.example src/.env

```

_Configure database credentials in `src/.env` if necessary._

**2. Start the Environment**

```bash
make fresh-start

```

_This command builds containers, installs dependencies, runs migrations, and seeds the database._

**3. Run Frontend Server**

```bash
make dev

```

_The application will be accessible at `http://localhost:8000`._

### Common Development Commands

- `make up` / `make down`: Start or stop containers.
- `make shell`: Access the app container shell as `www-data`.
- `make logs`: Tail container logs.
- `make migrate-fresh`: Drop all tables, re-migrate, and seed.
- `make test`: Run PHPUnit tests.

---

## Production Deployment

Production deployment uses the `docker-compose.prod.yml` configuration.

**1. Clone and Configure**

```bash
git clone https://github.com/raexera/MyLinx.git
cd MyLinx
cp src/.env.example src/.env

```

_Important: Update `src/.env` to set `APP_ENV=production`, `APP_DEBUG=false`, and assign secure database credentials._

**2. Deploy**

```bash
make prod-deploy

```

_This command pulls the latest code, installs production dependencies, builds frontend assets, runs migrations, and warms Laravel caches._

### Common Production Commands

- `make prod-up` / `make prod-down`: Start or stop production containers.
- `make prod-logs`: Tail the last 100 lines of production logs.
- `make prod-cache-clear`: Clear all Laravel caches.
- `make prod-db-backup`: Create a database backup inside the `backups/` directory.
- `make prod-db-restore FILE=backups/<file>.sql`: Restore the database from a backup (Warning: overwrites current data).
