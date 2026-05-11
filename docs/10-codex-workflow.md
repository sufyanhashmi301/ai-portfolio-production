# docs/10-codex-workflow.md

# Codex Workflow — Modern AI-Inspired Developer Portfolio

## 1. Purpose

This document defines how Codex should be used to implement the portfolio application safely and professionally.

The goal is to avoid random coding and instead use Codex in a controlled, phase-wise workflow based on the documentation already created.

Codex should help with:

- Creating files
- Implementing small features
- Running tests
- Fixing bugs
- Refactoring focused areas
- Preparing pull requests
- Summarizing changes

Codex should not be used to make uncontrolled changes across the whole project.

---

## 2. Core Rule

Do not ask Codex to build the full project in one prompt.

Use this workflow:

```text
Plan
↓
Documentation
↓
Small Codex task
↓
Review changes
↓
Run tests
↓
Commit
↓
Move to next task
```

Every Codex task should have:

1. Clear task
2. Relevant documentation context
3. Allowed file scope
4. Exact requirements
5. Restrictions
6. Testing instructions
7. Final summary requirements

---

## 3. Documentation Source of Truth

Codex must follow these documents:

```text
docs/
  01-project-plan.md
  02-requirements.md
  03-design-system.md
  04-database-schema.md
  05-api-specification.md
  06-frontend-architecture.md
  07-docker-setup.md
  08-testing-plan.md
  09-deployment-plan.md
  10-codex-workflow.md
```

Purpose of each document:

| Document | Purpose |
|---|---|
| `01-project-plan.md` | Overall roadmap and project vision |
| `02-requirements.md` | Required, optional, and postponed features |
| `03-design-system.md` | Visual design rules |
| `04-database-schema.md` | Database tables and relationships |
| `05-api-specification.md` | API endpoints and response shapes |
| `06-frontend-architecture.md` | Next.js structure and frontend rules |
| `07-docker-setup.md` | Local Docker environment |
| `08-testing-plan.md` | Testing strategy |
| `09-deployment-plan.md` | Deployment strategy |
| `10-codex-workflow.md` | AI coding workflow |

Codex should not invent a different architecture unless explicitly asked.

---

## 4. Human + ChatGPT + Codex Roles

## 4.1 Human Role

The human decides:

- Project direction
- Design preference
- Feature priority
- What should be accepted or rejected
- When to commit and deploy

---

## 4.2 ChatGPT Role

ChatGPT should be used for:

- Planning
- Documentation
- Architecture decisions
- Breaking work into small tasks
- Writing Codex prompts
- Reviewing implementation summaries
- Explaining why each step matters

---

## 4.3 Codex Role

Codex should be used for:

- Implementing documented tasks
- Creating or editing project files
- Running tests
- Fixing focused bugs
- Explaining changed files
- Preparing pull-request-ready changes

Codex should not be used for:

- Unplanned full-app rewrites
- Random dependency additions
- Changing unrelated files
- Hardcoding secrets
- Skipping tests
- Ignoring documentation

---

# 5. Branch Workflow

Use GitHub branches to keep work safe.

Recommended branches:

```text
main
develop
feature/docs-setup
feature/docker-setup
feature/frontend-base
feature/backend-api
feature/admin-panel
feature/tests
feature/deployment
```

## 5.1 Branch Rules

| Branch | Rule |
|---|---|
| `main` | Stable production-ready code only |
| `develop` | Active integration branch |
| `feature/*` | One focused phase or feature |

Rules:

1. Never work directly on `main`.
2. Create one branch per phase.
3. Keep commits small.
4. Review changes before merging.
5. Merge only when tests pass.
6. Use clear commit messages.

---

## 5.2 Suggested Commit Message Style

Use simple, clear commit messages:

```text
docs: add database schema documentation
chore: add docker compose setup
feat: add public project API
feat: add project card component
test: add project API feature tests
fix: hide missing project links
refactor: simplify API client
```

Recommended prefixes:

| Prefix | Use |
|---|---|
| `docs` | Documentation |
| `chore` | Setup/config/tooling |
| `feat` | New feature |
| `fix` | Bug fix |
| `test` | Tests |
| `refactor` | Code improvement without feature change |
| `style` | UI/style-only changes |

---

# 6. Standard Codex Prompt Format

Every Codex prompt should follow this structure:

```text
Task:
[One specific implementation task]

Context:
Use these documentation files:
- docs/[file-name].md
- docs/[file-name].md

Scope:
You may create or modify only:
- [allowed folder/file]
- [allowed folder/file]

Requirements:
- [specific requirement 1]
- [specific requirement 2]
- [specific requirement 3]

Do not:
- [restriction 1]
- [restriction 2]
- [restriction 3]

After implementation:
- List every changed file
- Explain what changed
- Explain how to test
- Mention commands you ran
- Mention any tests that failed
- Mention any pending issues
```

This structure prevents Codex from making broad, uncontrolled changes.

---

# 7. Universal Codex Safety Rules

Include these rules in most Codex prompts:

```text
Follow the existing documentation.
Do not modify unrelated files.
Keep changes small and phase-wise.
Mention every changed file.
Do not hardcode secrets.
Use environment variables.
Do not remove existing functionality.
Add or update tests where appropriate.
Run relevant tests if possible.
If tests fail, explain the failure clearly.
If unsure, stop and explain the issue.
```

---

# 8. Implementation Phases for Codex

Codex should implement the app in phases.

Recommended order:

```text
Phase 1 — Repository and base setup
Phase 2 — Docker local environment
Phase 3 — Backend database foundation
Phase 4 — Backend public APIs
Phase 5 — Backend admin APIs
Phase 6 — Frontend base setup
Phase 7 — Frontend design system
Phase 8 — Public frontend pages
Phase 9 — Admin frontend pages
Phase 10 — Testing
Phase 11 — Free/low-cost deployment
Phase 12 — Production polish
Phase 13 — AWS deployment later
```

---

# 9. Phase 1 — Repository and Base Setup

## Goal

Create the base monorepo structure.

## Allowed Scope

```text
frontend/
backend/
docs/
docker-compose.yml
README.md
.gitignore
```

## Codex Prompt

```text
Task:
Set up the initial monorepo structure for the portfolio app.

Context:
Use docs/01-project-plan.md as the source of truth.

Scope:
You may create:
- frontend/
- backend/
- docs/
- docker-compose.yml
- README.md
- .gitignore
- frontend/.env.example
- backend/.env.example

Requirements:
- Create a clean monorepo structure.
- Keep frontend and backend separate.
- Add placeholder README instructions.
- Add .env.example files.
- Add .gitignore rules for node_modules, vendor, .env, build output, and logs.
- Do not implement UI or backend logic yet.

Do not:
- Build pages.
- Build APIs.
- Add admin panel.
- Add unnecessary packages.
- Hardcode secrets.

After implementation:
- List changed files.
- Explain the structure.
- Mention next recommended step.
```

---

# 10. Phase 2 — Docker Local Environment

## Goal

Create Docker setup for frontend, backend, PostgreSQL, pgAdmin, and Mailpit.

## Documentation Context

```text
docs/07-docker-setup.md
```

## Codex Prompt

```text
Task:
Create the Docker local development setup.

Context:
Use docs/07-docker-setup.md.

Scope:
You may modify only:
- docker-compose.yml
- frontend/Dockerfile
- backend/Dockerfile
- frontend/.env.example
- backend/.env.example
- README.md

Requirements:
- Add services for frontend, backend, postgres, pgadmin, and mailpit.
- Frontend should run on localhost:3000.
- Backend should run on localhost:8000.
- PostgreSQL should run on localhost:5432.
- pgAdmin should run on localhost:5050.
- Mailpit should run on localhost:8025.
- Use environment variables.
- Do not hardcode production secrets.
- Add local setup commands to README.

Do not:
- Add Redis yet.
- Add AWS setup.
- Add Kubernetes.
- Add unrelated packages.

After implementation:
- List changed files.
- Explain how to run Docker.
- Include health check URLs.
- Mention any commands tested.
```

---

# 11. Phase 3 — Backend Database Foundation

## Goal

Create Laravel models, migrations, factories, and seeders.

## Documentation Context

```text
docs/04-database-schema.md
docs/08-testing-plan.md
```

## Codex Prompt

```text
Task:
Implement the Laravel database foundation for the portfolio app.

Context:
Use:
- docs/04-database-schema.md
- docs/08-testing-plan.md

Scope:
You may modify only:
- backend/database/migrations/
- backend/database/factories/
- backend/database/seeders/
- backend/app/Models/

Requirements:
- Create migrations for users, projects, project_media, technologies, project_technology, case_studies, and contact_inquiries.
- Add model relationships.
- Add factories for test data.
- Add seeders for admin user, technologies, sample projects, and sample case studies.
- Use environment variables for seeded admin credentials.
- Projects must allow optional image/video/live/GitHub/case study URLs.
- Case studies must allow nullable project_id.
- Use PostgreSQL-compatible column types.

Do not:
- Create API controllers yet.
- Create frontend code.
- Hardcode production credentials.
- Modify unrelated files.

After implementation:
- List changed files.
- Explain migration order.
- Explain seed data.
- Mention commands to run:
  php artisan migrate:fresh --seed
```

---

# 12. Phase 4 — Backend Public APIs

## Goal

Implement public APIs for projects, case studies, and contact form.

## Documentation Context

```text
docs/05-api-specification.md
docs/08-testing-plan.md
```

## Codex Prompt

```text
Task:
Implement public Laravel API endpoints.

Context:
Use:
- docs/05-api-specification.md
- docs/08-testing-plan.md

Scope:
You may modify only:
- backend/routes/api.php
- backend/app/Http/Controllers/
- backend/app/Http/Resources/
- backend/app/Http/Requests/
- backend/tests/Feature/
- backend/app/Models/ if relationships need small fixes

Requirements:
- Add GET /api/projects.
- Add GET /api/projects/featured.
- Add GET /api/projects/{slug}.
- Add GET /api/case-studies.
- Add GET /api/case-studies/{slug}.
- Add POST /api/contact.
- Public project endpoints must return only published projects.
- Public case study endpoints must return only published case studies.
- Draft detail pages must return 404.
- Contact form must validate and store inquiries.
- Add feature tests for public project APIs, case study APIs, and contact form.

Do not:
- Add admin APIs yet.
- Add frontend code.
- Return draft content publicly.
- Expose sensitive fields.

After implementation:
- List changed files.
- Explain endpoints added.
- Run php artisan test or explain why not.
- Mention any failing tests.
```

---

# 13. Phase 5 — Backend Admin APIs

## Goal

Implement admin authentication and protected admin management APIs.

## Documentation Context

```text
docs/05-api-specification.md
docs/08-testing-plan.md
```

## Codex Prompt

```text
Task:
Implement admin Laravel API endpoints.

Context:
Use:
- docs/05-api-specification.md
- docs/08-testing-plan.md

Scope:
You may modify only:
- backend/routes/api.php
- backend/app/Http/Controllers/
- backend/app/Http/Requests/
- backend/app/Http/Resources/
- backend/tests/Feature/
- backend/config/ if auth configuration is required

Requirements:
- Add admin login, logout, and me endpoints.
- Protect /api/admin/* routes except login.
- Add admin dashboard stats endpoint.
- Add project CRUD endpoints.
- Add project publish/unpublish/feature/unfeature endpoints.
- Add project media endpoints.
- Add technology CRUD endpoints.
- Add case study CRUD endpoints.
- Add case study publish/unpublish endpoints.
- Add inquiry list/detail/status/delete endpoints.
- Validate all write requests.
- Add admin feature tests.

Do not:
- Build frontend UI.
- Allow guest access to admin APIs.
- Expose password hashes.
- Modify unrelated files.

After implementation:
- List changed files.
- Explain admin endpoints added.
- Run php artisan test or explain why not.
- Mention any failing tests.
```

---

# 14. Phase 6 — Frontend Base Setup

## Goal

Create the Next.js frontend foundation.

## Documentation Context

```text
docs/06-frontend-architecture.md
docs/03-design-system.md
```

## Codex Prompt

```text
Task:
Set up the Next.js frontend foundation.

Context:
Use:
- docs/06-frontend-architecture.md
- docs/03-design-system.md

Scope:
You may modify only:
- frontend/app/
- frontend/components/
- frontend/lib/
- frontend/styles/
- frontend/package.json
- frontend/tailwind.config.*
- frontend/tsconfig.json
- frontend/.env.example

Requirements:
- Set up App Router structure.
- Add global layout.
- Add global styles.
- Add basic public layout shell.
- Add TypeScript path aliases if useful.
- Add environment variable example for NEXT_PUBLIC_API_URL.
- Keep UI minimal at this phase.

Do not:
- Build full pages yet.
- Build admin panel yet.
- Add unnecessary dependencies.
- Hardcode API URL.

After implementation:
- List changed files.
- Explain setup.
- Run typecheck/build if possible.
```

---

# 15. Phase 7 — Frontend Design System

## Goal

Create reusable UI and subtle AI-inspired effects.

## Documentation Context

```text
docs/03-design-system.md
docs/06-frontend-architecture.md
```

## Codex Prompt

```text
Task:
Implement the frontend design system components.

Context:
Use:
- docs/03-design-system.md
- docs/06-frontend-architecture.md

Scope:
You may modify only:
- frontend/components/ui/
- frontend/components/effects/
- frontend/styles/globals.css
- frontend/lib/utils/

Requirements:
- Create Button, Card, Badge, Container, SectionHeading, EmptyState, LoadingState, ErrorState, and StatusBadge components.
- Create subtle effect components: AnimatedGridBackground, GradientGlow, GlassPanel, GlowBorderCard, MotionWrapper.
- Add a GradientProjectPlaceholder component if appropriate.
- Keep design modern, decent, premium, and professional.
- Use subtle AI-inspired effects only.
- Ensure components are responsive.

Do not:
- Build complete pages yet.
- Over-animate.
- Use childish colors.
- Add unrelated UI libraries unless necessary.

After implementation:
- List changed files.
- Explain design components.
- Run typecheck/build if possible.
```

---

# 16. Phase 8 — Public Frontend Pages

## Goal

Build public portfolio pages connected to the API.

## Documentation Context

```text
docs/06-frontend-architecture.md
docs/05-api-specification.md
docs/03-design-system.md
```

## Codex Prompt

```text
Task:
Implement the public frontend pages.

Context:
Use:
- docs/06-frontend-architecture.md
- docs/05-api-specification.md
- docs/03-design-system.md

Scope:
You may modify only:
- frontend/app/
- frontend/components/home/
- frontend/components/projects/
- frontend/components/case-studies/
- frontend/components/contact/
- frontend/lib/api/
- frontend/lib/types/
- frontend/lib/utils/

Requirements:
- Build homepage.
- Build about page.
- Build projects page.
- Build project detail page.
- Build case studies page.
- Build case study detail page.
- Build contact page.
- Connect pages to Laravel API through frontend/lib/api.
- Add TypeScript types for API data.
- Show gradient placeholder when project image is missing.
- Hide Live/GitHub/Video/Case Study buttons when URLs are missing.
- Add loading, empty, error, and not-found states where appropriate.
- Keep design premium and mobile responsive.

Do not:
- Build admin UI yet.
- Hardcode API data except temporary fallback content if documented.
- Show broken images.
- Show buttons for missing links.

After implementation:
- List changed files.
- Explain pages added.
- Run typecheck/build if possible.
- Mention how to test pages locally.
```

---

# 17. Phase 9 — Admin Frontend Pages

## Goal

Build admin dashboard and content management UI.

## Documentation Context

```text
docs/06-frontend-architecture.md
docs/05-api-specification.md
docs/03-design-system.md
```

## Codex Prompt

```text
Task:
Implement the admin frontend pages.

Context:
Use:
- docs/06-frontend-architecture.md
- docs/05-api-specification.md
- docs/03-design-system.md

Scope:
You may modify only:
- frontend/app/admin/
- frontend/components/admin/
- frontend/components/layout/Admin*
- frontend/lib/api/admin*
- frontend/lib/types/
- frontend/lib/utils/

Requirements:
- Build admin login page.
- Build admin layout with sidebar and header.
- Build admin dashboard.
- Build projects table.
- Build project create/edit form.
- Build case studies table.
- Build case study create/edit form.
- Build inquiries table.
- Build inquiry detail page.
- Connect admin UI to Laravel admin APIs.
- Handle loading, errors, validation messages, and empty states.
- Protect admin routes on frontend as much as possible.
- Keep admin UI clean and professional.

Do not:
- Modify public pages unless necessary.
- Add multi-admin roles yet.
- Add file upload UI yet.
- Hardcode credentials.

After implementation:
- List changed files.
- Explain admin flows.
- Run typecheck/build if possible.
- Mention how to test admin locally.
```

---

# 18. Phase 10 — Testing

## Goal

Add and run backend and frontend tests.

## Documentation Context

```text
docs/08-testing-plan.md
```

## Codex Prompt

```text
Task:
Add critical backend and frontend tests.

Context:
Use docs/08-testing-plan.md.

Scope:
You may modify only:
- backend/tests/
- frontend/tests/
- frontend/playwright.config.*
- frontend/package.json if test scripts are needed

Requirements:
- Add Laravel tests for public projects, case studies, contact form, admin auth, admin projects, admin case studies, and inquiries.
- Add Playwright tests for homepage, projects page, project detail, missing image fallback, missing link buttons, contact form, mobile navigation, and admin login.
- Add npm scripts for Playwright if missing.
- Keep tests focused on important user flows.

Do not:
- Rewrite app logic unless tests reveal a small required fix.
- Add unrelated tests.
- Ignore failing tests.

After implementation:
- List changed files.
- Explain tests added.
- Run tests if possible.
- Mention any failing tests and likely causes.
```

---

# 19. Phase 11 — Deployment Preparation

## Goal

Prepare the app for free/low-cost deployment.

## Documentation Context

```text
docs/09-deployment-plan.md
```

## Codex Prompt

```text
Task:
Prepare the app for first free/low-cost deployment.

Context:
Use docs/09-deployment-plan.md.

Scope:
You may modify only:
- README.md
- frontend/.env.example
- backend/.env.example
- backend/config/cors.php if needed
- deployment notes or docs if needed

Requirements:
- Ensure frontend API URL is environment-based.
- Ensure backend FRONTEND_URL is environment-based.
- Ensure production env examples are clear.
- Add deployment checklist to README.
- Add CORS notes.
- Add build/test commands.
- Do not add AWS setup yet.

Do not:
- Hardcode production domains.
- Commit secrets.
- Add unrelated infrastructure.
- Add Kubernetes.

After implementation:
- List changed files.
- Explain deployment readiness.
- Mention required environment variables.
```

---

# 20. Phase 12 — Production Polish

## Goal

Improve SEO, loading states, accessibility, performance, and overall quality.

## Codex Prompt

```text
Task:
Add production polish to the portfolio.

Context:
Use:
- docs/03-design-system.md
- docs/06-frontend-architecture.md
- docs/08-testing-plan.md
- docs/09-deployment-plan.md

Scope:
Limit changes to frontend polish and small backend response improvements if necessary.

Requirements:
- Add SEO metadata.
- Add Open Graph fallback image support.
- Improve 404 page.
- Improve loading states.
- Improve error states.
- Check accessibility basics.
- Improve mobile spacing.
- Optimize obvious performance issues.
- Keep animations subtle.

Do not:
- Add new major features.
- Rewrite architecture.
- Add AWS.
- Add blog/newsletter/testimonials unless separately requested.

After implementation:
- List changed files.
- Explain improvements.
- Run typecheck/build/tests if possible.
```

---

# 21. Code Review Checklist

After Codex completes a task, review:

## 21.1 Scope Review

| Check | Pass/Fail |
|---|---|
| Only allowed files were changed |  |
| No unrelated files were modified |  |
| No large unexpected rewrite happened |  |
| No secrets were committed |  |
| Documentation was followed |  |

---

## 21.2 Code Quality Review

| Check | Pass/Fail |
|---|---|
| Code is readable |  |
| TypeScript types are clear |  |
| Laravel validation is used |  |
| API response shape matches docs |  |
| Components are reusable |  |
| No duplicated unnecessary logic |  |
| No hardcoded API URLs |  |
| Error handling exists |  |

---

## 21.3 Design Review

| Check | Pass/Fail |
|---|---|
| UI looks modern and professional |  |
| Effects are subtle |  |
| Mobile layout works |  |
| Missing image fallback works |  |
| Missing buttons are hidden |  |
| Text is readable |  |
| Spacing is consistent |  |

---

## 21.4 Testing Review

| Check | Pass/Fail |
|---|---|
| Relevant tests were added |  |
| Backend tests pass |  |
| Frontend typecheck passes |  |
| Frontend build passes |  |
| Playwright tests pass where applicable |  |
| Failing tests are explained |  |

---

# 22. How to Handle Codex Mistakes

If Codex makes mistakes:

## 22.1 If It Changes Unrelated Files

Action:

- Reject those changes.
- Ask Codex to redo with a narrower scope.
- Mention exact allowed files.

Prompt:

```text
You modified unrelated files. Revert those changes and only modify:
- [allowed file 1]
- [allowed file 2]

Do not touch any other files.
```

---

## 22.2 If It Adds Unwanted Dependencies

Action:

- Ask why dependency is needed.
- Remove it unless clearly justified.

Prompt:

```text
Remove the newly added dependency unless it is essential.
Use existing tools and simple code where possible.
Explain why any remaining dependency is necessary.
```

---

## 22.3 If Tests Fail

Action:

- Ask Codex to inspect the failing test output.
- Fix only the related issue.
- Do not allow broad rewrites.

Prompt:

```text
Fix only the failing tests shown below.
Do not refactor unrelated code.
Explain the cause of each failure and the exact fix.
```

---

## 22.4 If UI Looks Too Noisy

Action:

- Ask Codex to simplify.

Prompt:

```text
The design is too noisy. Simplify it according to docs/03-design-system.md.
Keep the premium AI-inspired style, but reduce excessive animations, colors, and visual clutter.
```

---

# 23. Good Codex Task Size

Good task size:

- One page
- One component group
- One API controller group
- One test file group
- One bug fix
- One refactor

Bad task size:

- Build full app
- Build frontend and backend together
- Fix all bugs
- Improve everything
- Make it production-ready in one step
- Redesign the whole site

---

# 24. Example Small Tasks

Good examples:

```text
Create the ProjectCard component with missing image fallback.
```

```text
Implement GET /api/projects and tests.
```

```text
Create Laravel migration and model for case_studies.
```

```text
Add Playwright test for hiding missing project buttons.
```

```text
Build admin project table only.
```

```text
Fix CORS config for local frontend.
```

---

# 25. Required Summary After Every Codex Task

Codex must end with this summary format:

```text
Changed files:
- file 1
- file 2

What changed:
- summary point 1
- summary point 2

How to test:
- command 1
- command 2

Test results:
- passed/failed/not run

Pending issues:
- issue 1 or "None"
```

This makes review easier.

---

# 26. Commands Codex Should Commonly Run

## 26.1 Backend

```bash
php artisan test
php artisan migrate
php artisan migrate:fresh --seed
php artisan route:list
php artisan optimize:clear
```

With Docker:

```bash
docker compose exec backend php artisan test
docker compose exec backend php artisan migrate:fresh --seed
```

---

## 26.2 Frontend

```bash
npm run typecheck
npm run lint
npm run build
npx playwright test
```

With Docker:

```bash
docker compose exec frontend npm run typecheck
docker compose exec frontend npm run lint
docker compose exec frontend npm run build
docker compose exec frontend npx playwright test
```

---

# 27. Environment Variable Rules

Codex must never hardcode secrets.

Use:

```text
.env
.env.example
platform environment variables
```

Frontend public variables:

```env
NEXT_PUBLIC_API_URL=
```

Backend variables:

```env
APP_KEY=
APP_URL=
FRONTEND_URL=
DB_HOST=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
ADMIN_EMAIL=
ADMIN_PASSWORD=
```

Rules:

1. `.env` is never committed.
2. `.env.example` is committed.
3. Production values are set in hosting platforms.
4. API URLs must be configurable.
5. Admin password must not be hardcoded.

---

# 28. When to Stop Codex

Codex should stop and explain if:

1. Required documentation is missing.
2. A command fails repeatedly.
3. A dependency decision is unclear.
4. A file conflict appears.
5. A migration may destroy data.
6. A change requires production secrets.
7. Scope is too broad.
8. It cannot safely complete the task.

Stopping is better than making risky changes.

---

# 29. Final Development Workflow

Recommended daily workflow:

```text
1. Pick one small task.
2. Ask ChatGPT to prepare Codex prompt.
3. Run Codex on a feature branch.
4. Review changed files.
5. Run tests.
6. Fix small issues.
7. Commit.
8. Push branch.
9. Merge after review.
10. Move to next task.
```

---

# 30. What to Use Codex For Now vs Later

## 30.1 Use Codex Now For

| Task | Use Codex? |
|---|---|
| Creating monorepo structure | Yes |
| Docker setup | Yes |
| Laravel migrations | Yes |
| Laravel API endpoints | Yes |
| API tests | Yes |
| Next.js components | Yes |
| Public pages | Yes |
| Admin pages | Yes |
| Playwright tests | Yes |
| Bug fixes | Yes, focused only |

---

## 30.2 Use Codex Later For

| Task | Reason |
|---|---|
| AWS deployment scripts | Later phase |
| S3 upload integration | After media upload is needed |
| CI/CD workflows | After local workflow is stable |
| Advanced admin roles | After MVP |
| Blog/newsletter modules | After core portfolio |
| Analytics dashboard | After launch |

---

# 31. Acceptance Criteria

This Codex workflow is ready when:

- Codex responsibilities are clear.
- ChatGPT responsibilities are clear.
- Human review responsibilities are clear.
- Branch workflow is defined.
- Standard prompt format is defined.
- Phase-wise prompts are ready.
- Safety rules are clear.
- Testing requirements are included.
- Code review checklist is included.
- Mistake recovery process is included.
- Final summary format is defined.

---

# 32. Next Recommended Step

After completing all documentation files, the next step is:

```text
Create the GitHub repository and set up the base monorepo structure.
```

Recommended first implementation branch:

```text
feature/docs-setup
```

Then copy all documentation files into:

```text
docs/
```

After documentation is committed, start implementation with:

```text
feature/docker-setup
```

Do not jump directly into public UI or admin panel before the base project and Docker setup are stable.
