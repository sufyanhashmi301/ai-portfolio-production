# AI Portfolio Production (Phase 1 Foundation)

This repository contains the Phase 1 production-ready foundation for an AI-powered developer portfolio.

## Stack
- Frontend: Next.js (App Router), TypeScript, Tailwind CSS, Framer Motion
- Backend: Laravel API (scaffold structure)
- Database: PostgreSQL
- Local infra: Docker Compose (frontend, backend, postgres, pgAdmin, Mailpit)
- Testing: Playwright baseline setup

## Repository Structure

```text
frontend/        # Next.js app
backend/         # Laravel API structure
docs/            # project documentation
docker-compose.yml
```

## Health Checks
- Frontend: `http://localhost:3000`
- Backend API: `http://localhost:8000/api/health`

## Local Setup (Docker)

1. Copy environment files if needed:
   ```bash
   cp .env.example .env
   cp frontend/.env.example frontend/.env.local
   cp backend/.env.example backend/.env
   ```

2. Build and start all services:
   ```bash
   docker compose up --build -d
   ```

3. View logs:
   ```bash
   docker compose logs -f frontend backend
   ```

4. Stop services:
   ```bash
   docker compose down
   ```

## Notes
- This phase intentionally excludes admin panel, authentication, project CRUD, and AI assistant implementation.
- Playwright is configured only as a baseline; no full E2E tests are included yet.
