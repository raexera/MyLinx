---
description: Start the MyLinx development environment
---

## Prerequisites (first time only)

Run these once after cloning the repo:

1. Copy the environment file:
```bash
cp src/.env.example src/.env
```

2. Build the Docker containers:
```bash
make build
```

3. Start the containers:
```bash
make up
```

4. Install all dependencies (Composer + NPM):
```bash
make install
```

5. Generate the app key:
```bash
make key-generate
```

6. Run migrations:
```bash
make migrate
```

---

## Daily Development

Every time you start working, run these two commands:

// turbo
1. Start all containers:
```bash
make up
```

// turbo
2. Start Vite dev server (hot-reload):
```bash
make dev
```

Then open:
- **Laravel app:** http://localhost:8000
- **Vite HMR:** http://localhost:5173

---

## Notes

- PostgreSQL is exposed on host port **5433** (not 5432) to avoid conflicts with local Postgres.
- All `make` commands must be run from the project root (`/Desktop/MyLinx`), not from `src/`.
- DB credentials are defined in `docker-compose.yml`: `mylinx / mylinx / secret`.
- To stop containers: `make down`
- To see all available commands: `make help`
