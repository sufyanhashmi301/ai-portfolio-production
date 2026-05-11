# docs/09-deployment-plan.md

# Deployment Plan — Modern AI-Inspired Developer Portfolio

## 1. Purpose

This document defines the deployment strategy for the modern AI-inspired developer portfolio application.

The deployment plan follows two stages:

1. **Free / low-cost deployment first**
2. **AWS deployment later**

The goal is to deploy the application professionally without adding unnecessary cost or complexity too early.

This document covers:

- Recommended first deployment architecture
- Frontend deployment
- Backend deployment
- PostgreSQL hosting
- Environment variables
- CORS configuration
- Domain setup
- Production checklist
- Testing after deployment
- Future AWS deployment plan

---

## 2. Deployment Philosophy

The project should not start directly with AWS.

AWS is powerful, but it adds complexity in:

- Networking
- IAM permissions
- VPCs
- ECS / EC2 configuration
- RDS setup
- S3 permissions
- CloudFront
- Secrets Manager
- Monitoring and billing

For the first production version, use simpler services so the focus remains on:

- Building the portfolio
- Showing projects professionally
- Making the API stable
- Learning deployment step by step
- Keeping cost low

Recommended approach:

```text
Local Docker development
↓
Free / low-cost deployment
↓
Production polish
↓
AWS migration later
```

---

# 3. Deployment Stages

## 3.1 Stage 1 — Free / Low-Cost Deployment

Recommended first deployment:

| Layer | Recommended Option |
|---|---|
| Frontend | Vercel |
| Backend | Render, Railway, Fly.io, or low-cost VPS |
| Database | Supabase PostgreSQL, Neon, Render PostgreSQL, or Railway PostgreSQL |
| Media | URL fields first, Cloudinary later |
| Email | Mail provider later, Mailpit only local |
| Domain | Namecheap, GoDaddy, Cloudflare, or existing domain |
| Repository | GitHub |

Best simple setup:

```text
Next.js frontend → Vercel
Laravel API → Render or Railway
PostgreSQL → Supabase or Neon
Media → URL fields first
GitHub → Source control
```

---

## 3.2 Stage 2 — AWS Deployment Later

Later AWS deployment:

| Layer | AWS Service |
|---|---|
| Frontend | AWS Amplify or S3 + CloudFront |
| Backend | ECS Fargate or EC2 |
| Database | RDS PostgreSQL |
| Media | S3 |
| CDN | CloudFront |
| DNS | Route 53 |
| SSL | AWS Certificate Manager |
| Secrets | AWS Secrets Manager |
| Logs | CloudWatch |

AWS should be done only after the application is stable.

---

# 4. Recommended First Deployment Architecture

## 4.1 Architecture Diagram

```text
Visitor Browser
      ↓
Vercel Frontend
      ↓
Laravel API on Render/Railway/Fly.io
      ↓
Managed PostgreSQL Database
```

Optional later:

```text
Cloudinary / S3 for media
Email provider for contact notifications
Custom domain with SSL
```

---

## 4.2 Why This Architecture?

This architecture is recommended because:

1. Vercel is excellent for Next.js.
2. Render/Railway/Fly.io are simpler than AWS for Laravel deployment.
3. Supabase/Neon provide managed PostgreSQL without manual server setup.
4. GitHub integration makes deployment easier.
5. It keeps monthly cost low.
6. It allows faster learning and iteration.
7. AWS can still be added later.

---

# 5. GitHub Deployment Preparation

Before deploying, the project should be in GitHub.

Recommended branches:

```text
main
develop
feature/*
```

Branch rules:

| Branch | Purpose |
|---|---|
| `main` | Stable production code |
| `develop` | Active development |
| `feature/*` | Phase-wise work |

Deployment recommendation:

| Environment | Branch |
|---|---|
| Production | `main` |
| Preview/Staging | `develop` or pull requests |

---

## 5.1 Pre-Deployment Git Checklist

Before first deployment:

- Code pushed to GitHub.
- `.env` files are not committed.
- `.env.example` files are committed.
- README has local setup instructions.
- Docker works locally.
- Backend tests pass.
- Frontend build passes.
- API URLs are not hardcoded.
- CORS is configurable.
- Production secrets are ready.

---

# 6. Frontend Deployment — Vercel

## 6.1 Why Vercel?

Vercel is the best first deployment option for Next.js because:

- Easy GitHub integration
- Automatic deployments
- Preview deployments
- Free/low-cost start
- Built-in SSL
- Good Next.js support

---

## 6.2 Vercel Setup Steps

1. Push project to GitHub.
2. Open Vercel.
3. Import GitHub repository.
4. Select the frontend directory:

```text
frontend
```

5. Set framework preset:

```text
Next.js
```

6. Add environment variables.
7. Deploy.

---

## 6.3 Vercel Environment Variables

Production frontend env:

```env
NEXT_PUBLIC_API_URL=https://your-backend-domain.com/api
```

Important:

Only variables prefixed with `NEXT_PUBLIC_` are exposed to the browser.

Do not store private secrets in frontend env variables.

---

## 6.4 Vercel Build Settings

| Setting | Value |
|---|---|
| Framework | Next.js |
| Root Directory | `frontend` |
| Build Command | `npm run build` |
| Output Directory | `.next` |
| Install Command | `npm install` |

---

## 6.5 Vercel Deployment Checks

After deployment, check:

- Homepage loads.
- Projects page loads.
- API data loads.
- Project detail pages work.
- Case study pages work.
- Contact form submits.
- No CORS errors in browser console.
- No missing environment variable error.
- Mobile layout works.

---

# 7. Backend Deployment Options

The Laravel API can be deployed using one of these options:

| Option | Difficulty | Cost | Notes |
|---|---|---|---|
| Render | Easy | Free/low-cost | Good first choice |
| Railway | Easy | Low-cost | Developer-friendly |
| Fly.io | Medium | Low-cost | Good for containers |
| DigitalOcean/VPS | Medium | Low-cost | More manual control |
| AWS EC2/ECS | Harder | Variable | Later phase |

Recommended first choice:

```text
Render or Railway
```

---

# 8. Backend Deployment — Render Option

## 8.1 Why Render?

Render is a good first backend deployment option because:

- GitHub integration
- Environment variables UI
- Managed deployment
- Supports web services
- Supports Docker or build commands
- Easier than AWS

---

## 8.2 Render Deployment Preparation

Backend root:

```text
backend
```

Laravel production requirements:

- `APP_ENV=production`
- `APP_DEBUG=false`
- Production `APP_KEY`
- PostgreSQL database URL/config
- Correct `APP_URL`
- Correct `FRONTEND_URL`
- CORS configured
- Cache optimized
- Migrations run

---

## 8.3 Render Environment Variables

Example:

```env
APP_NAME="Portfolio API"
APP_ENV=production
APP_KEY=base64:your-generated-production-key
APP_DEBUG=false
APP_URL=https://your-backend-domain.com
FRONTEND_URL=https://your-frontend-domain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-mail-username
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@yourdomain.com
MAIL_FROM_NAME="Portfolio"

ADMIN_NAME="Sufyan"
ADMIN_EMAIL=your-admin-email@example.com
ADMIN_PASSWORD=strong-temporary-password
```

Important:

- Use a strong admin password.
- Change seeded admin password after first login if needed.
- Never use local development passwords in production.

---

## 8.4 Render Build Command

Possible build command:

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If migrations should run automatically:

```bash
php artisan migrate --force
```

However, be careful with automatic migrations in production.

For first deployment, it is acceptable to run migrations manually through the platform console.

---

## 8.5 Render Start Command

If using Laravel's built-in server for simple deployment:

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

For more production-like deployment, use Nginx + PHP-FPM later.

First version can remain simple.

---

# 9. Backend Deployment — Railway Option

## 9.1 Why Railway?

Railway is useful because:

- Easy GitHub deployment
- Built-in environment variables
- PostgreSQL add-on
- Simple logs
- Good developer experience

---

## 9.2 Railway Setup

1. Create Railway project.
2. Connect GitHub repository.
3. Select backend folder.
4. Add PostgreSQL service or connect external database.
5. Add Laravel environment variables.
6. Deploy backend.
7. Run migrations.
8. Test API endpoints.

---

## 9.3 Railway Notes

Use Railway if:

- You want a quick developer-friendly deployment.
- You want backend and database in one platform.
- You prefer less manual server setup.

---

# 10. Database Hosting Options

Recommended PostgreSQL providers:

| Provider | Notes |
|---|---|
| Supabase | Good free/low-cost PostgreSQL |
| Neon | Serverless PostgreSQL, good developer experience |
| Railway PostgreSQL | Easy with Railway backend |
| Render PostgreSQL | Easy with Render backend |
| AWS RDS | Later AWS phase |

Recommended first choice:

```text
Supabase or Neon
```

---

## 10.1 Database Setup Steps

1. Create PostgreSQL database.
2. Copy connection credentials.
3. Add credentials to backend environment variables.
4. Run Laravel migrations.
5. Run seeders if needed.
6. Verify tables exist.
7. Test API endpoints.

---

## 10.2 Production Database Rules

Production database must:

- Use strong password.
- Not expose unnecessary public access.
- Be backed up if possible.
- Use SSL if provider requires it.
- Be separate from local database.
- Never use local Docker credentials.

---

# 11. Media Storage Strategy

## 11.1 First Version

Use URL fields only:

- `thumbnail_url`
- `video_url`
- `live_url`
- `github_url`
- `case_study_url`
- `cover_image_url`

This means no file upload is needed for the first version.

Benefits:

- Simpler deployment
- No storage cost
- Faster development
- Easier admin forms

---

## 11.2 Later Media Options

Later, add one of:

| Option | Use Case |
|---|---|
| Cloudinary | Easy image/video hosting |
| AWS S3 | AWS production phase |
| Laravel local storage | Not recommended for serverless/ephemeral platforms |

Recommended later:

```text
Cloudinary first
AWS S3 later
```

---

# 12. Email Strategy

## 12.1 First Version

For first version, contact form should store inquiries in database.

Email sending can be optional.

This ensures the contact form still works even before email provider setup.

---

## 12.2 Later Email Providers

Possible providers:

| Provider | Notes |
|---|---|
| Mailgun | Good Laravel support |
| SendGrid | Common but quota-sensitive |
| Resend | Developer-friendly |
| Amazon SES | Good later with AWS |
| SMTP from domain host | Simple but can be limited |

Recommended:

```text
Store inquiries first
Add email notification later
```

---

# 13. CORS Configuration

Laravel must allow the deployed frontend domain.

Production frontend example:

```text
https://yourdomain.com
```

Backend `.env`:

```env
FRONTEND_URL=https://yourdomain.com
```

CORS should allow:

- Local frontend during development
- Production frontend during production

Do not use wildcard `*` in production if credentials/auth cookies are used.

---

## 13.1 CORS Checklist

Check:

- Frontend can call `/api/projects`.
- Frontend can call `/api/projects/featured`.
- Frontend can call `/api/case-studies`.
- Contact form can submit.
- Admin login works.
- Browser console has no CORS error.

---

# 14. Domain Setup

## 14.1 Recommended Domain Structure

Option A:

```text
yourdomain.com
api.yourdomain.com
```

Recommended.

Option B:

```text
portfolio.yourdomain.com
api.yourdomain.com
```

Good if the domain is used for other business sites.

---

## 14.2 DNS Records

Typical records:

| Purpose | Type | Example |
|---|---|---|
| Frontend | CNAME / A | Vercel target |
| Backend API | CNAME / A | Render/Railway target |
| SSL | Managed by platform | Vercel/Render/Railway |
| Email | MX/TXT | Later email provider |

---

## 14.3 SSL

Use platform-provided SSL first.

Vercel, Render, and Railway can provide HTTPS automatically.

Do not deploy production without HTTPS.

---

# 15. Production Environment Variables Checklist

## 15.1 Frontend Production Env

```env
NEXT_PUBLIC_API_URL=https://api.yourdomain.com/api
```

---

## 15.2 Backend Production Env

```env
APP_NAME="Portfolio API"
APP_ENV=production
APP_KEY=base64:production-key
APP_DEBUG=false
APP_URL=https://api.yourdomain.com
FRONTEND_URL=https://yourdomain.com

DB_CONNECTION=pgsql
DB_HOST=production-db-host
DB_PORT=5432
DB_DATABASE=production-db-name
DB_USERNAME=production-db-user
DB_PASSWORD=production-db-password

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="Portfolio"
```

---

# 16. Production Build Commands

## 16.1 Frontend

Run locally before deployment:

```bash
docker compose exec frontend npm run typecheck
docker compose exec frontend npm run lint
docker compose exec frontend npm run build
```

---

## 16.2 Backend

Run locally before deployment:

```bash
docker compose exec backend php artisan test
docker compose exec backend php artisan optimize:clear
```

Production optimization commands:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If needed:

```bash
php artisan migrate --force
```

---

# 17. Deployment Testing Checklist

## 17.1 Public Website

Check after deployment:

| Check | Pass/Fail |
|---|---|
| Homepage loads |  |
| Hero section visible |  |
| Featured projects load |  |
| Projects page loads |  |
| Project detail page loads |  |
| Missing project images show placeholder |  |
| Missing project links are hidden |  |
| Case studies page loads |  |
| Case study detail page loads |  |
| About page loads |  |
| Contact page loads |  |
| Contact form submits |  |
| Mobile navigation works |  |
| 404 page works |  |

---

## 17.2 Admin Panel

Check after deployment:

| Check | Pass/Fail |
|---|---|
| Admin login page loads |  |
| Invalid login is rejected |  |
| Valid login works |  |
| Dashboard loads |  |
| Project list loads |  |
| Create project works |  |
| Edit project works |  |
| Publish/unpublish works |  |
| Feature/unfeature works |  |
| Case study list loads |  |
| Create case study works |  |
| Inquiry list loads |  |
| Logout works |  |

---

## 17.3 API Checks

Open these URLs:

```text
https://api.yourdomain.com/api/projects
https://api.yourdomain.com/api/projects/featured
https://api.yourdomain.com/api/case-studies
```

Expected:

- JSON response.
- No debug errors.
- No HTML error page.
- No CORS error from frontend.

---

# 18. Common Deployment Problems

## 18.1 CORS Error

Symptoms:

- Browser console shows CORS blocked request.

Fix:

- Check backend CORS config.
- Add production frontend URL to allowed origins.
- Confirm `FRONTEND_URL` is correct.
- Clear Laravel config cache.

Command:

```bash
php artisan config:clear
php artisan config:cache
```

---

## 18.2 500 Server Error

Symptoms:

- API returns server error.

Fix:

- Check logs.
- Confirm `.env` variables.
- Confirm `APP_KEY`.
- Confirm database credentials.
- Confirm migrations have run.
- Set `APP_DEBUG=false` in production, but inspect platform logs.

---

## 18.3 Database Connection Failed

Fix:

- Confirm DB host.
- Confirm DB port.
- Confirm DB name.
- Confirm DB username/password.
- Confirm database allows platform connection.
- Confirm SSL requirements if provider requires SSL.

---

## 18.4 Frontend Cannot Find API

Fix:

- Confirm `NEXT_PUBLIC_API_URL`.
- Redeploy frontend after env variable changes.
- Check API URL includes `/api`.
- Check backend is live.

---

## 18.5 Admin Login Fails

Fix:

- Confirm admin user exists.
- Run admin seeder.
- Confirm password hash.
- Confirm auth config.
- Confirm cookies/token handling.
- Check CORS and Sanctum config if using cookie-based auth.

---

## 18.6 Contact Form Does Not Submit

Fix:

- Check browser console.
- Check backend validation response.
- Check CORS.
- Check rate limiting.
- Check API URL.
- Check contact endpoint route.

---

# 19. Rollback Strategy

For first deployment:

## 19.1 Frontend Rollback

Use Vercel deployment history.

Rollback to previous successful deployment if needed.

---

## 19.2 Backend Rollback

Options:

- Revert Git commit.
- Redeploy previous commit.
- Restore previous environment variables.
- Restore database backup if migrations caused data problems.

---

## 19.3 Database Rollback

Be careful with production migrations.

Before risky migrations:

- Backup database.
- Test migration locally.
- Test migration on staging if available.
- Avoid destructive changes unless necessary.

---

# 20. Staging Environment Later

A staging environment is useful before production.

Recommended later setup:

| Layer | Staging |
|---|---|
| Frontend | Vercel preview deployment |
| Backend | Separate Render/Railway service |
| Database | Separate PostgreSQL database |
| Domain | `staging.yourdomain.com` and `staging-api.yourdomain.com` |

Do not use production database for staging.

---

# 21. Monitoring and Logs

## 21.1 First Version

Use platform logs:

- Vercel logs
- Render/Railway logs
- Database provider logs

Check logs for:

- 500 errors
- Failed API calls
- Contact form errors
- Auth errors
- Database connection errors

---

## 21.2 Later Monitoring

Later add:

- Sentry for frontend/backend errors
- Uptime monitoring
- Laravel logs dashboard
- CloudWatch when on AWS

---

# 22. AWS Deployment Later

AWS should be a later phase after the app is stable.

## 22.1 AWS Target Architecture

```text
User
 ↓
CloudFront
 ↓
Frontend on S3 or Amplify

Frontend calls:
 ↓
API Domain
 ↓
Application Load Balancer
 ↓
ECS Fargate / EC2 running Laravel
 ↓
RDS PostgreSQL

Media:
S3 + CloudFront

Secrets:
AWS Secrets Manager

Logs:
CloudWatch
```

---

## 22.2 AWS Services

| Service | Purpose |
|---|---|
| Route 53 | Domain and DNS |
| ACM | SSL certificates |
| CloudFront | CDN |
| S3 | Static/media storage |
| Amplify | Optional frontend hosting |
| ECS Fargate | Containerized Laravel API |
| EC2 | Simpler server option |
| RDS PostgreSQL | Managed database |
| Secrets Manager | Environment secrets |
| CloudWatch | Logs and monitoring |
| IAM | Permissions |

---

## 22.3 AWS Migration Steps Later

1. Prepare production Dockerfile for Laravel.
2. Move media storage to S3.
3. Create RDS PostgreSQL database.
4. Import existing production data.
5. Deploy Laravel API to ECS or EC2.
6. Configure domain through Route 53.
7. Add SSL through ACM.
8. Add CloudFront if needed.
9. Move secrets to Secrets Manager.
10. Configure logs in CloudWatch.
11. Test full application.
12. Switch DNS after successful testing.

---

## 22.4 AWS Should Be Postponed Because

AWS should not be first because:

- It is more expensive if misconfigured.
- It requires more DevOps knowledge.
- It slows down early portfolio development.
- It creates too many moving parts.
- Free/low-cost platforms are enough for first launch.

---

# 23. Deployment Order

Recommended order:

## Step 1 — Local Stability

- Docker works.
- Backend tests pass.
- Frontend build passes.
- Seed data works.
- Public pages work locally.
- Admin panel works locally.

---

## Step 2 — GitHub Preparation

- Push code to GitHub.
- Confirm `.env` is ignored.
- Confirm `.env.example` exists.
- Confirm README setup is clear.

---

## Step 3 — Database Deployment

- Create PostgreSQL database.
- Add database credentials to backend hosting platform.
- Run migrations.
- Run seeders if needed.

---

## Step 4 — Backend Deployment

- Deploy Laravel API.
- Add environment variables.
- Run migrations.
- Test public endpoints.
- Test admin login.

---

## Step 5 — Frontend Deployment

- Deploy Next.js frontend to Vercel.
- Add `NEXT_PUBLIC_API_URL`.
- Test frontend API calls.
- Test public pages.

---

## Step 6 — Domain Setup

- Connect frontend domain.
- Connect API subdomain.
- Confirm HTTPS works.

---

## Step 7 — Final Production QA

- Test public pages.
- Test admin.
- Test contact form.
- Test mobile.
- Test missing media/link fallbacks.
- Check logs.

---

# 24. What to Deploy Now vs Later

## 24.1 Deploy Now

| Item | Deploy Now? |
|---|---|
| Public website | Yes |
| Laravel API | Yes |
| PostgreSQL database | Yes |
| Admin panel | Yes |
| Contact inquiry storage | Yes |
| URL-based media fields | Yes |
| Vercel frontend | Yes |
| Render/Railway backend | Yes |
| Supabase/Neon PostgreSQL | Yes |

---

## 24.2 Deploy Later

| Item | Reason |
|---|---|
| AWS ECS/RDS | Later production maturity |
| S3 media uploads | File upload postponed |
| CloudFront media CDN | Later media optimization |
| Advanced monitoring | Add after first launch |
| CI/CD pipeline | Add after local workflow stabilizes |
| Staging environment | Add after first deployment |
| Multi-region deployment | Not needed |
| Kubernetes | Unnecessary complexity |

---

# 25. Production Acceptance Criteria

Deployment is successful when:

- Frontend is live on HTTPS.
- Backend API is live on HTTPS.
- PostgreSQL production database is connected.
- Public projects load from API.
- Featured projects load from API.
- Case studies load from API.
- Contact form stores inquiry.
- Admin login works.
- Admin can create/edit/publish projects.
- Missing images show fallback UI.
- Missing links are hidden.
- Mobile layout works.
- No CORS errors.
- No exposed debug errors.
- Environment variables are correctly configured.
- Production secrets are not committed to GitHub.

---

# 26. Next Recommended Document

After this document, create:

```text
docs/10-codex-workflow.md
```

That document should define:

- How to use Codex phase-wise
- How to write safe Codex prompts
- Rules for implementation tasks
- File scope control
- Testing after every phase
- GitHub branch workflow
- Code review checklist
- How ChatGPT and Codex should work together
