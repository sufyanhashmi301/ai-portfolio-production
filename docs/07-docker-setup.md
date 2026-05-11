# docs/07-docker-setup.md

# Docker Setup — Modern AI-Inspired Developer Portfolio

## 1. Purpose

This document defines the Docker-based local development environment for the portfolio application.

The goal is to make the project easy to run locally with a consistent setup for:

- Next.js frontend
- Laravel API backend
- PostgreSQL database
- pgAdmin database UI
- Mailpit local email testing
- Optional Redis later

This document should be followed when creating:

- `docker-compose.yml`
- Frontend Dockerfile
- Backend Dockerfile
- Environment files
- Local setup commands
- Database migration workflow

---

## 2. Why Use Docker?

Docker helps us avoid common local development problems.

Without Docker, every machine needs manual setup for:

- Node.js
- PHP
- Composer
- PostgreSQL
- Extensions
- Mail testing tools
- Environment variables

With Docker, the project runs through containers, so the setup becomes more consistent and professional.

Benefits:

1. Easier local setup.
2. Same environment for frontend, backend, and database.
3. Cleaner onboarding for future work.
4. Better production-readiness.
5. Easier deployment preparation later.
6. Less conflict with existing tools installed on Windows.

---

## 3. Recommended Local Architecture

The local Docker setup should contain these services:

| Service | Purpose |
|---|---|
| `frontend` | Next.js app |
| `backend` | Laravel API |
| `postgres` | PostgreSQL database |
| `pgadmin` | Database visual UI |
| `mailpit` | Local email testing |
| `redis` | Optional later for queues/cache |

Recommended first version:

```text
frontend
backend
postgres
pgadmin
mailpit
```

Redis can be added later when queues, cache, or background jobs are needed.

---

## 4. Recommended Repository Structure

The monorepo should look like this:

```text
portfolio-app/
  frontend/
    Dockerfile
    package.json
    .env.example

  backend/
    Dockerfile
    composer.json
    .env.example

  docs/
    01-project-plan.md
    02-requirements.md
    03-design-system.md
    04-database-schema.md
    05-api-specification.md
    06-frontend-architecture.md
    07-docker-setup.md

  docker/
    nginx/
      default.conf
    php/
      php.ini

  docker-compose.yml
  .env
  .gitignore
  README.md
```

For the first version, Nginx can be skipped if Laravel runs through `php artisan serve`.

Later, Nginx can be added for a more production-like local environment.

---

## 5. Docker Services Overview

## 5.1 Frontend Service

Service name:

```text
frontend
```

Purpose:

Runs the Next.js development server.

Expected local URL:

```text
http://localhost:3000
```

Container port:

```text
3000
```

Responsibilities:

- Run Next.js app
- Use TypeScript
- Use Tailwind CSS
- Connect to Laravel API through environment variable

Frontend environment variable:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

---

## 5.2 Backend Service

Service name:

```text
backend
```

Purpose:

Runs the Laravel API.

Expected local URL:

```text
http://localhost:8000
```

Container port:

```text
8000
```

Responsibilities:

- Serve Laravel API
- Connect to PostgreSQL
- Handle admin authentication
- Handle projects, case studies, contact form, and admin APIs
- Send local emails through Mailpit during development

Backend environment variables:

```env
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=portfolio_password
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

---

## 5.3 PostgreSQL Service

Service name:

```text
postgres
```

Purpose:

Stores application data.

Expected local port:

```text
5432
```

Database credentials for local development:

```env
POSTGRES_DB=portfolio
POSTGRES_USER=portfolio
POSTGRES_PASSWORD=portfolio_password
```

Important:

Local database credentials are for development only.

Production credentials must be different and stored securely.

---

## 5.4 pgAdmin Service

Service name:

```text
pgadmin
```

Purpose:

Provides a browser-based UI to inspect and manage the PostgreSQL database.

Expected local URL:

```text
http://localhost:5050
```

Default local credentials:

```env
PGADMIN_DEFAULT_EMAIL=admin@example.com
PGADMIN_DEFAULT_PASSWORD=admin
```

Important:

These are local development credentials only.

Do not use them in production.

---

## 5.5 Mailpit Service

Service name:

```text
mailpit
```

Purpose:

Catches local emails without sending them to real users.

Expected local URL:

```text
http://localhost:8025
```

SMTP port inside Docker:

```text
1025
```

Use cases:

- Contact form email notification testing
- Admin notification testing
- Password reset testing later

---

## 6. Recommended `docker-compose.yml`

Create this file at:

```text
docker-compose.yml
```

Recommended first version:

```yaml
services:
  frontend:
    build:
      context: ./frontend
      dockerfile: Dockerfile
    container_name: portfolio_frontend
    ports:
      - "3000:3000"
    volumes:
      - ./frontend:/app
      - frontend_node_modules:/app/node_modules
    environment:
      NEXT_PUBLIC_API_URL: http://localhost:8000/api
    depends_on:
      - backend
    command: npm run dev

  backend:
    build:
      context: ./backend
      dockerfile: Dockerfile
    container_name: portfolio_backend
    ports:
      - "8000:8000"
    volumes:
      - ./backend:/var/www/html
      - backend_vendor:/var/www/html/vendor
    environment:
      APP_ENV: local
      APP_DEBUG: true
      APP_URL: http://localhost:8000
      FRONTEND_URL: http://localhost:3000

      DB_CONNECTION: pgsql
      DB_HOST: postgres
      DB_PORT: 5432
      DB_DATABASE: portfolio
      DB_USERNAME: portfolio
      DB_PASSWORD: portfolio_password

      MAIL_MAILER: smtp
      MAIL_HOST: mailpit
      MAIL_PORT: 1025
      MAIL_USERNAME: null
      MAIL_PASSWORD: null
      MAIL_ENCRYPTION: null
      MAIL_FROM_ADDRESS: hello@example.com
      MAIL_FROM_NAME: Portfolio

    depends_on:
      - postgres
      - mailpit
    command: php artisan serve --host=0.0.0.0 --port=8000

  postgres:
    image: postgres:16-alpine
    container_name: portfolio_postgres
    restart: unless-stopped
    ports:
      - "5432:5432"
    environment:
      POSTGRES_DB: portfolio
      POSTGRES_USER: portfolio
      POSTGRES_PASSWORD: portfolio_password
    volumes:
      - postgres_data:/var/lib/postgresql/data

  pgadmin:
    image: dpage/pgadmin4:latest
    container_name: portfolio_pgadmin
    restart: unless-stopped
    ports:
      - "5050:80"
    environment:
      PGADMIN_DEFAULT_EMAIL: admin@example.com
      PGADMIN_DEFAULT_PASSWORD: admin
    depends_on:
      - postgres
    volumes:
      - pgadmin_data:/var/lib/pgadmin

  mailpit:
    image: axllent/mailpit:latest
    container_name: portfolio_mailpit
    restart: unless-stopped
    ports:
      - "8025:8025"
      - "1025:1025"

volumes:
  postgres_data:
  pgadmin_data:
  frontend_node_modules:
  backend_vendor:
```

---

## 7. Frontend Dockerfile

Create this file:

```text
frontend/Dockerfile
```

Recommended development version:

```dockerfile
FROM node:22-alpine

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 3000

CMD ["npm", "run", "dev"]
```

Notes:

- This is for local development.
- Production Dockerfile can be optimized later.
- Use `npm` first for simplicity.
- pnpm/yarn/bun can be considered later if needed.

---

## 8. Backend Dockerfile

Create this file:

```text
backend/Dockerfile
```

Recommended development version:

```dockerfile
FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock* ./

RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

COPY . .

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

Notes:

- `composer install || true` allows the container to build before Laravel is fully installed, but after the project is stable, remove `|| true`.
- For production, use a more optimized PHP-FPM + Nginx setup.
- For local development, `php artisan serve` is acceptable and simple.

---

## 9. Environment Files

## 9.1 Root `.env`

Optional root `.env` for Docker Compose:

```env
COMPOSE_PROJECT_NAME=portfolio_app

POSTGRES_DB=portfolio
POSTGRES_USER=portfolio
POSTGRES_PASSWORD=portfolio_password

PGADMIN_DEFAULT_EMAIL=admin@example.com
PGADMIN_DEFAULT_PASSWORD=admin
```

---

## 9.2 Frontend `.env.example`

File:

```text
frontend/.env.example
```

Content:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

---

## 9.3 Backend `.env.example`

File:

```text
backend/.env.example
```

Content:

```env
APP_NAME="Portfolio API"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=portfolio_password

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"

ADMIN_NAME="Sufyan"
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=password
```

Important:

- Never commit real production credentials.
- `.env` files should be ignored by Git.
- `.env.example` files should be committed.

---

## 10. Git Ignore Rules

Root `.gitignore` should include:

```gitignore
.env
.env.local
.env.*.local

node_modules
vendor

.DS_Store
Thumbs.db

frontend/.next
frontend/out
frontend/node_modules

backend/vendor
backend/storage/logs/*.log
backend/bootstrap/cache/*.php

docker-data
```

---

## 11. Local Development Commands

## 11.1 Start Containers

From project root:

```bash
docker compose up -d --build
```

This starts:

- Frontend
- Backend
- PostgreSQL
- pgAdmin
- Mailpit

---

## 11.2 Stop Containers

```bash
docker compose down
```

---

## 11.3 Stop Containers and Remove Volumes

Use carefully:

```bash
docker compose down -v
```

This deletes database data stored in Docker volumes.

---

## 11.4 View Logs

All services:

```bash
docker compose logs -f
```

Specific service:

```bash
docker compose logs -f frontend
docker compose logs -f backend
docker compose logs -f postgres
```

---

## 11.5 Enter Frontend Container

```bash
docker compose exec frontend sh
```

---

## 11.6 Enter Backend Container

```bash
docker compose exec backend bash
```

If bash is not available:

```bash
docker compose exec backend sh
```

---

## 12. Laravel Setup Commands

Run inside the backend container:

```bash
docker compose exec backend php artisan key:generate
```

Run migrations:

```bash
docker compose exec backend php artisan migrate
```

Run seeders:

```bash
docker compose exec backend php artisan db:seed
```

Run migrations fresh with seeders:

```bash
docker compose exec backend php artisan migrate:fresh --seed
```

Clear Laravel cache:

```bash
docker compose exec backend php artisan optimize:clear
```

Run Laravel tests:

```bash
docker compose exec backend php artisan test
```

---

## 13. Frontend Setup Commands

Install packages:

```bash
docker compose exec frontend npm install
```

Run type check:

```bash
docker compose exec frontend npm run typecheck
```

Run lint:

```bash
docker compose exec frontend npm run lint
```

Run build:

```bash
docker compose exec frontend npm run build
```

Run Playwright tests later:

```bash
docker compose exec frontend npx playwright test
```

---

## 14. pgAdmin Setup

Open:

```text
http://localhost:5050
```

Login:

```text
Email: admin@example.com
Password: admin
```

Add new server:

| Field | Value |
|---|---|
| Name | Portfolio Local |
| Host | postgres |
| Port | 5432 |
| Database | portfolio |
| Username | portfolio |
| Password | portfolio_password |

Important:

Inside Docker, pgAdmin connects to PostgreSQL using service name:

```text
postgres
```

Do not use `localhost` inside pgAdmin for the database host.

---

## 15. Mailpit Usage

Open:

```text
http://localhost:8025
```

Laravel mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

Use Mailpit to inspect:

- Contact form emails
- Admin notifications
- Password reset emails later

---

## 16. CORS Setup

Laravel must allow the Next.js frontend origin.

Local frontend origin:

```text
http://localhost:3000
```

Backend `.env`:

```env
FRONTEND_URL=http://localhost:3000
```

Recommended CORS behavior:

- Allow local frontend in development.
- Allow production frontend domain in production.
- Do not allow all origins in production.

---

## 17. Service URLs

| Service | URL |
|---|---|
| Frontend | `http://localhost:3000` |
| Backend API | `http://localhost:8000/api` |
| Laravel root | `http://localhost:8000` |
| PostgreSQL | `localhost:5432` |
| pgAdmin | `http://localhost:5050` |
| Mailpit | `http://localhost:8025` |

---

## 18. Health Check Workflow

After starting Docker, check:

## 18.1 Frontend

Open:

```text
http://localhost:3000
```

Expected:

- Next.js frontend loads.
- No terminal errors.

## 18.2 Backend

Open:

```text
http://localhost:8000
```

Expected:

- Laravel app responds.

Open:

```text
http://localhost:8000/api/projects
```

Expected:

- JSON response.
- Empty `data` array is fine before seeders.

## 18.3 Database

Run:

```bash
docker compose exec postgres psql -U portfolio -d portfolio
```

Expected:

- PostgreSQL shell opens.

## 18.4 pgAdmin

Open:

```text
http://localhost:5050
```

Expected:

- pgAdmin login page appears.

## 18.5 Mailpit

Open:

```text
http://localhost:8025
```

Expected:

- Mailpit inbox appears.

---

## 19. Common Troubleshooting

## 19.1 Docker Engine Not Starting on Windows

Possible fixes:

1. Make sure WSL2 is installed.
2. Restart Docker Desktop.
3. Restart Windows.
4. Check that virtualization is enabled in BIOS.
5. Run:

```bash
wsl --status
```

6. Run:

```bash
wsl --list --verbose
```

7. Make sure Docker Desktop is using WSL2 backend.

---

## 19.2 Port Already in Use

If port `3000`, `8000`, `5432`, `5050`, or `8025` is already in use, either stop the conflicting service or change the port mapping.

Example:

```yaml
ports:
  - "3001:3000"
```

This means local machine uses port `3001`, but container still uses `3000`.

---

## 19.3 Backend Cannot Connect to Database

Check `.env`:

```env
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=portfolio_password
```

Inside Docker, the database host must be:

```text
postgres
```

Not:

```text
localhost
```

---

## 19.4 Frontend Cannot Connect to Backend

Check frontend env:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Check backend CORS config.

Check backend is running:

```bash
docker compose logs -f backend
```

---

## 19.5 Laravel Key Missing

Run:

```bash
docker compose exec backend php artisan key:generate
```

---

## 19.6 Composer Dependencies Missing

Run:

```bash
docker compose exec backend composer install
```

---

## 19.7 Node Modules Missing

Run:

```bash
docker compose exec frontend npm install
```

---

## 19.8 Database Needs Reset

Use carefully:

```bash
docker compose exec backend php artisan migrate:fresh --seed
```

If Docker volume must be removed:

```bash
docker compose down -v
docker compose up -d --build
```

---

## 20. Development Rules

Follow these rules during implementation:

1. Do not hardcode secrets.
2. Use `.env.example` for sample values.
3. Do not commit real `.env` files.
4. Keep Docker setup simple first.
5. Do not add AWS-specific setup yet.
6. Do not add Kubernetes.
7. Do not add complex CI/CD until the app runs locally.
8. Keep Docker changes phase-wise.
9. Test each service after setup.
10. Document every changed file after implementation.

---

## 21. Recommended Build Order

## Step 1 — Create Monorepo Structure

Create:

```text
frontend/
backend/
docs/
docker-compose.yml
README.md
.gitignore
```

---

## Step 2 — Create Frontend App

Inside `frontend/`:

- Next.js
- TypeScript
- Tailwind CSS
- Basic homepage
- Dockerfile
- `.env.example`

---

## Step 3 — Create Backend App

Inside `backend/`:

- Laravel API
- PostgreSQL config
- Dockerfile
- `.env.example`

---

## Step 4 — Add Docker Compose

Create services:

- frontend
- backend
- postgres
- pgadmin
- mailpit

---

## Step 5 — Verify Local Services

Check:

- `http://localhost:3000`
- `http://localhost:8000`
- `http://localhost:5050`
- `http://localhost:8025`

---

## Step 6 — Run Backend Migrations

Run:

```bash
docker compose exec backend php artisan migrate
```

---

## Step 7 — Add Seeders

Seed:

- Admin user
- Technologies
- Sample projects
- Sample case studies

---

## Step 8 — Add API and Frontend Integration

Once Docker is stable, build:

- Laravel API endpoints
- Next.js API client
- Public pages
- Admin pages

---

## 22. Production Notes

This Docker setup is for local development.

Production deployment should be handled separately in:

```text
docs/09-deployment-plan.md
```

Production setup will likely use:

| Layer | First Deployment | Later AWS Deployment |
|---|---|---|
| Frontend | Vercel | AWS Amplify or S3 + CloudFront |
| Backend | Render / Railway / Fly.io | ECS Fargate or EC2 |
| Database | Supabase / Neon / Render PostgreSQL | AWS RDS PostgreSQL |
| Media | URL fields first / Cloudinary later | S3 + CloudFront |
| Secrets | Platform env vars | AWS Secrets Manager |

Do not overcomplicate the first local Docker setup with production concerns.

---

## 23. What to Build Now vs Later

## 23.1 Build Now

| Item | Include Now? |
|---|---|
| Docker Compose | Yes |
| Frontend service | Yes |
| Backend service | Yes |
| PostgreSQL service | Yes |
| pgAdmin service | Yes |
| Mailpit service | Yes |
| `.env.example` files | Yes |
| Local setup commands | Yes |
| Laravel migration commands | Yes |
| Basic troubleshooting notes | Yes |

---

## 23.2 Postpone

| Item | Reason |
|---|---|
| Redis | Not needed until queues/cache are used |
| Nginx reverse proxy | Can be added later |
| Production Dockerfile | Later deployment phase |
| Kubernetes | Unnecessary complexity |
| AWS ECS setup | Later AWS phase |
| GitHub Actions deployment | After app runs locally |
| S3 media storage | Later media/upload phase |

---

## 24. Acceptance Criteria

This Docker setup is ready when:

- `docker-compose.yml` defines required services.
- Frontend runs on `localhost:3000`.
- Backend runs on `localhost:8000`.
- PostgreSQL is available on `localhost:5432`.
- pgAdmin runs on `localhost:5050`.
- Mailpit runs on `localhost:8025`.
- Laravel can connect to PostgreSQL.
- Next.js can call Laravel API.
- Environment variables are documented.
- `.env.example` files are defined.
- Common commands are documented.
- Troubleshooting notes are included.
- Production concerns are postponed to deployment documentation.

---

## 25. Next Recommended Document

After this document, create:

```text
docs/08-testing-plan.md
```

That document should define:

- Laravel backend testing
- Playwright frontend testing
- API test cases
- Admin flow test cases
- Public page test cases
- Missing media/link test cases
- Contact form test cases
- CI testing strategy later
