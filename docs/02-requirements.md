# 02 — Portfolio Requirements

## Document Status

| Item | Details |
|---|---|
| Project | Modern AI-Inspired Developer Portfolio |
| Document | `docs/02-requirements.md` |
| Phase | Phase 0 — Documentation and Planning |
| Status | Final planning draft before coding |
| Purpose | Define exactly what the portfolio must do, what is required, what is optional, and what should be postponed |

---

## 1. Purpose of This Document

This document converts the high-level project plan into implementation-ready requirements.

The goal is to prevent random coding, unclear scope, and unnecessary complexity. Before writing any code, this file defines:

1. What the portfolio must include.
2. What features are required in the first production version.
3. What features are optional.
4. What should be postponed until later phases.
5. What rules the frontend, backend, admin panel, database, Docker setup, testing, and deployment must follow.

This document should be used together with:

```text
docs/01-project-plan.md
docs/02-requirements.md
```

Future documents will define design system, database schema, API specification, frontend architecture, Docker setup, testing, deployment, and Codex workflow in more detail.

---

## 2. Product Vision Requirement

The portfolio must present Sufyan as a serious, professional full-stack developer with expertise in:

- Laravel
- API development
- Modern frontend development
- Next.js
- TypeScript
- Dashboard and admin systems
- ERP, CRM, FinTech, and automation projects
- Docker-based development
- AI-assisted development workflow

The portfolio must feel like a premium SaaS-style personal brand platform, not a basic CV website.

### Required Design Direction

The design must be:

- Modern
- Decent
- Premium
- Professional
- Mobile responsive
- AI-inspired but subtle
- Clean and readable
- Suitable for clients, recruiters, and collaborators

### Not Allowed

The design must not be:

- Childish
- Over-animated
- Too colorful
- Noisy
- Cluttered
- Template-looking
- Difficult to read on mobile

---

## 3. User Types

## 3.1 Public Visitor

A public visitor may be:

- Potential client
- Recruiter
- Company owner
- Technical lead
- Collaborator
- Viewer from GitHub, LinkedIn, Fiverr, Upwork, or direct link

The public visitor should be able to:

- Understand who Sufyan is.
- View skills and experience.
- Browse projects.
- Open project details.
- Read case studies.
- Contact Sufyan.
- View optional project media and links when available.

## 3.2 Admin User

The admin user is Sufyan or an authorized portfolio manager.

The admin should be able to:

- Log in securely.
- Manage projects.
- Manage case studies.
- Manage contact inquiries.
- Publish or unpublish content.
- Mark selected projects as featured.
- Add optional project media and links without breaking the public UI.

---

## 4. Core Requirement Principles

These principles must guide all implementation.

| Principle | Requirement |
|---|---|
| Documentation first | No coding before planning documents are ready |
| Production mindset | Structure must support future deployment and scaling |
| Optional content support | Missing media or links must not break the UI |
| Clean architecture | Frontend, backend, database, and tests must be organized clearly |
| Small phases | Build in controlled steps, not one large messy implementation |
| Environment safety | No API keys or secrets hardcoded |
| Responsive UI | Mobile, tablet, and desktop must be supported |
| Testability | Important user flows must be testable |
| Low-cost first | Deploy cheaply/free first, AWS later |
| Admin-managed content | Projects and case studies should be manageable without editing code |

---

## 5. Required Public Pages

## 5.1 Home Page

Route:

```text
/
```

### Purpose

The homepage must immediately communicate:

- Who Sufyan is.
- What he builds.
- What technologies he uses.
- What kind of projects he has worked on.
- Why someone should trust him.
- How to contact or view his work.

### Required Sections

| Section | Required? | Notes |
|---|---:|---|
| Hero section | Yes | Main professional introduction |
| CTA buttons | Yes | At least “View Projects” and “Contact Me” |
| Featured projects | Yes | Pulled from backend/API |
| Skills snapshot | Yes | Grouped tech highlights |
| Experience highlights | Yes | Laravel/API/full-stack/FinTech/ERP strengths |
| Work process | Yes | Short explanation of how he works |
| Contact CTA | Yes | Clear conversion section |
| Case study preview | Optional for V1 | Can appear when case studies exist |

### Required Hero Content

The hero section must include:

- Name or professional identity
- Primary role
- Short positioning statement
- CTA buttons
- Subtle AI-inspired visual element

Example positioning direction:

```text
I build scalable Laravel, API, and full-stack web applications with modern frontend experiences, clean architecture, and production-ready engineering.
```

### Required Design Rules

- Use a premium dark or deep neutral background.
- Add subtle grid or gradient effect.
- Keep text readable.
- Avoid too many moving elements.
- CTA buttons must be visible on mobile.

---

## 5.2 Projects Page

Route:

```text
/projects
```

### Purpose

The projects page must show portfolio work in a professional card/grid layout.

### Required Features

| Feature | Required? | Notes |
|---|---:|---|
| Project cards | Yes | Display project summary |
| Project title | Yes | Required field |
| Short description | Yes | Required field |
| Tech stack badges | Yes | Should show if available |
| Category | Optional | Useful for filtering |
| Project image | Optional | Must have fallback if missing |
| Gradient placeholder | Yes | Required when no image exists |
| Featured badge | Optional | Show only if featured |
| Live link button | Optional | Hide if missing |
| GitHub button | Optional | Hide if missing |
| Case study button | Optional | Hide if missing |
| Video button | Optional | Hide if missing |
| Filters | Optional for V1 | Can be added after basic listing |

### Important Requirement

If a project has no image, the UI must show a professional gradient placeholder.

If a project has no live link, GitHub link, video link, or case study link, the related button must not render.

The card must still look complete.

---

## 5.3 Project Detail Page

Route:

```text
/projects/[slug]
```

### Purpose

The project detail page must explain one project in a deeper, more professional way.

### Required Sections

| Section | Required? | Notes |
|---|---:|---|
| Project title | Yes | From API |
| Short summary | Yes | From API |
| Long description | Optional | Show if available |
| Problem solved | Optional | Can be added later |
| Features developed | Optional | Recommended for strong projects |
| Tech stack | Yes | Show badges if available |
| Architecture notes | Optional | Useful for technical credibility |
| Media section | Optional | Show only if media exists |
| Links section | Optional | Hide missing buttons |
| Related projects | Postponed | Later enhancement |

### Fallback Requirement

If no project image or video exists, the page must still look premium using:

- Gradient hero block
- Clean typography
- Tech badges
- Structured content cards
- Optional icon-style placeholder

---

## 5.4 Case Studies Page

Route:

```text
/case-studies
```

### Purpose

Case studies must show deeper technical and business storytelling.

### V1 Requirement

Case studies are required in the database/API/admin plan, but public case study pages may be implemented after the basic project showcase if time is limited.

### Required When Implemented

| Feature | Required? |
|---|---:|
| Case study list | Yes |
| Case study title | Yes |
| Summary | Yes |
| Related project | Optional |
| Cover image | Optional |
| Published/draft handling | Yes |
| Empty state if no case studies | Yes |

---

## 5.5 Case Study Detail Page

Route:

```text
/case-studies/[slug]
```

### Required Sections

| Section | Required? |
|---|---:|
| Title | Yes |
| Summary | Yes |
| Problem | Optional |
| Role and responsibilities | Optional |
| Tech stack | Optional |
| Solution | Optional |
| Challenges | Optional |
| Results | Optional |
| Full content | Yes |
| Media | Optional |
| CTA | Yes |

### Rule

A case study should not be just a project description. It should explain:

- Context
- Problem
- Technical decision-making
- Outcome
- Lessons learned

---

## 5.6 About Page

Route:

```text
/about
```

### Required Content

The About page must explain:

- Professional background
- Laravel experience
- Full-stack development experience
- API integration experience
- Dashboard/admin system experience
- ERP/CRM/FinTech exposure
- Clean architecture mindset
- AI-assisted development approach
- Work values

### Required Tone

The tone must be:

- Confident
- Professional
- Clear
- Not exaggerated
- Client/recruiter friendly

---

## 5.7 Contact Page

Route:

```text
/contact
```

### Required Features

| Feature | Required? | Notes |
|---|---:|---|
| Contact form | Yes | Name, email, message |
| Subject field | Optional | Recommended |
| Project type field | Optional | Later |
| Email/social links | Optional | Can be simple |
| Contact CTA | Yes | Encourage serious inquiries |
| Backend inquiry storage | Yes for V1 | Store in database |
| Email sending | Optional for V1 | Can be added later |

### Required Validation

Contact form must validate:

- Name is required.
- Email is required and valid.
- Message is required.
- Subject is optional.

### Spam Protection

Basic spam protection is postponed. It can be added later through:

- Rate limiting
- Honeypot field
- CAPTCHA
- Admin moderation

---

## 6. Required Admin Features

## 6.1 Admin Authentication

### Required

Admin authentication must include:

- Login
- Logout
- Protected admin routes
- Current admin user endpoint
- Secure password hashing
- Environment-safe credentials
- No hardcoded secrets

### Recommended V1 Approach

Use Laravel backend authentication with one seeded admin user for local development.

Authentication implementation details will be finalized in the API/auth document.

---

## 6.2 Admin Dashboard

### Required Dashboard Metrics

| Metric | Required? |
|---|---:|
| Total projects | Yes |
| Featured projects | Yes |
| Published projects | Yes |
| Draft projects | Yes |
| Total case studies | Yes |
| Contact inquiries | Yes |
| Recent inquiries | Optional |

### Dashboard Requirement

Dashboard should be simple in V1. It does not need advanced charts.

---

## 6.3 Project Management

Admin must be able to:

- Create a project.
- Edit a project.
- Delete a project.
- Publish/unpublish a project.
- Mark/unmark a project as featured.
- Set project display order.
- Add optional image URL.
- Add optional video URL.
- Add optional live URL.
- Add optional GitHub URL.
- Add optional case study URL.
- Add technologies.
- Add category.

### Required Project Fields

| Field | Required? | Rule |
|---|---:|---|
| Title | Yes | Cannot be empty |
| Slug | Yes | Auto-generated, editable |
| Short description | Yes | Required for cards |
| Long description | Optional | Used on detail page |
| Category | Optional | Helpful for filtering |
| Tech stack | Optional but recommended | Show badges when available |
| Thumbnail image | Optional | Gradient placeholder if missing |
| Gallery images | Optional | Postponed if needed |
| Video URL | Optional | Hide button if missing |
| Live URL | Optional | Hide button if missing |
| GitHub URL | Optional | Hide button if missing |
| Case study link | Optional | Hide button if missing |
| Featured | Yes | Boolean |
| Published/status | Yes | Draft or published |
| Sort order | Optional | Default 0 |

---

## 6.4 Case Study Management

Admin must be able to:

- Create case study.
- Edit case study.
- Delete case study.
- Publish/unpublish case study.
- Attach case study to a project optionally.
- Add optional media.
- Add SEO title and description optionally.

### Required Case Study Fields

| Field | Required? |
|---|---:|
| Title | Yes |
| Slug | Yes |
| Summary | Yes |
| Full content | Yes |
| Problem | Optional |
| Solution | Optional |
| Results | Optional |
| Tech stack | Optional |
| Related project | Optional |
| Cover image | Optional |
| SEO title | Optional |
| SEO description | Optional |
| Status | Yes |

---

## 6.5 Contact Inquiry Management

Admin must be able to:

- View submitted inquiries.
- View inquiry details.
- Mark inquiries as read/unread/replied.
- Delete inquiries.
- Filter inquiries later.

### V1 Requirement

Basic listing and status management are enough.

Advanced CRM-like features are postponed.

---

## 7. Backend Requirements

## 7.1 Laravel API

The backend must be a Laravel API responsible for:

- Public portfolio data
- Admin authentication
- Project CRUD
- Case study CRUD
- Contact form submission
- Validation
- Database interaction
- API responses

## 7.2 API Response Style

API responses must be consistent.

Recommended shape:

```json
{
  "data": {},
  "message": "Success"
}
```

For validation errors:

```json
{
  "message": "The given data was invalid.",
  "errors": {}
}
```

## 7.3 Public API Requirements

Public APIs must only return published content.

Required public endpoints:

```text
GET /api/projects
GET /api/projects/featured
GET /api/projects/{slug}
GET /api/case-studies
GET /api/case-studies/{slug}
POST /api/contact
```

## 7.4 Admin API Requirements

Admin APIs must require authentication.

Required admin endpoints:

```text
POST /api/admin/login
POST /api/admin/logout
GET /api/admin/me

GET /api/admin/projects
POST /api/admin/projects
GET /api/admin/projects/{id}
PUT/PATCH /api/admin/projects/{id}
DELETE /api/admin/projects/{id}
PATCH /api/admin/projects/{id}/publish
PATCH /api/admin/projects/{id}/unpublish
PATCH /api/admin/projects/{id}/feature
PATCH /api/admin/projects/{id}/unfeature

GET /api/admin/case-studies
POST /api/admin/case-studies
GET /api/admin/case-studies/{id}
PUT/PATCH /api/admin/case-studies/{id}
DELETE /api/admin/case-studies/{id}
PATCH /api/admin/case-studies/{id}/publish
PATCH /api/admin/case-studies/{id}/unpublish

GET /api/admin/inquiries
GET /api/admin/inquiries/{id}
PATCH /api/admin/inquiries/{id}/status
DELETE /api/admin/inquiries/{id}
```

---

## 8. Database Requirements

The database must support:

- Admin users
- Projects
- Project media
- Technologies
- Project technology relationship
- Case studies
- Contact inquiries

Required tables:

```text
users
projects
project_media
technologies
project_technology
case_studies
contact_inquiries
```

### Required Database Rules

- Slugs must be unique.
- Public queries must filter by `published` status.
- Optional media/link fields must allow null.
- Contact inquiries must store submission date.
- Admin password must be hashed.
- Delete behavior must be planned carefully before implementation.

Detailed fields will be finalized in:

```text
docs/04-database-schema.md
```

---

## 9. Frontend Requirements

## 9.1 Framework

The frontend must use:

- Next.js
- TypeScript
- Tailwind CSS
- Framer Motion

## 9.2 Frontend Responsibilities

The frontend must:

- Render public pages.
- Consume Laravel API.
- Render admin panel.
- Handle responsive layout.
- Render fallback UI for missing content.
- Hide missing optional buttons.
- Provide loading and error states.
- Use reusable components.
- Keep design consistent.

## 9.3 Required Component Categories

```text
components/layout
components/home
components/projects
components/case-studies
components/admin
components/ui
components/effects
lib/api
lib/types
lib/utils
```

## 9.4 Required UI Components

| Component | Required? |
|---|---:|
| Navbar | Yes |
| Footer | Yes |
| Container | Yes |
| Button | Yes |
| Card | Yes |
| Badge | Yes |
| SectionHeading | Yes |
| GradientPlaceholder | Yes |
| EmptyState | Yes |
| LinkButtonGroup | Yes |
| MotionWrapper | Yes |
| ProjectCard | Yes |
| ProjectGrid | Yes |
| ProjectLinks | Yes |
| ProjectTechStack | Yes |
| AdminLayout | Yes when admin starts |
| ProjectForm | Yes when admin starts |

---

## 10. Design Requirements

## 10.1 Required Visual Style

The design must use:

- Soft gradients
- Glass-style cards
- Subtle AI grid background
- Glow borders in selected areas
- Smooth animation
- Clean typography
- Spacious layout
- Premium dark/neutral base

## 10.2 Required Animation Rules

Animations must be:

- Smooth
- Subtle
- Purposeful
- Not distracting
- Reduced on mobile if needed

Allowed animations:

- Fade in
- Slide up
- Gentle hover
- Soft glow movement
- Very subtle background motion

Avoid:

- Bouncing text
- Excessive particles
- Flashing colors
- Fast motion
- Too many simultaneous animations

## 10.3 Accessibility Requirements

The UI must:

- Use readable font sizes.
- Maintain good contrast.
- Provide visible focus states.
- Avoid text over busy backgrounds.
- Use semantic HTML where possible.
- Keep mobile navigation accessible.

---

## 11. Optional Content Rules

This is one of the most important requirements.

The portfolio must support incomplete project content professionally.

## 11.1 Optional Project Fields

The following may be missing:

- Thumbnail image
- Gallery images
- Video URL
- Live URL
- GitHub URL
- Case study URL
- Long description
- Category
- Dates
- Results
- Architecture notes

## 11.2 Required Fallback Behavior

| Missing Item | Required Behavior |
|---|---|
| Thumbnail image | Show professional gradient placeholder |
| Gallery images | Hide gallery section |
| Video URL | Hide video button/section |
| Live URL | Hide live demo button |
| GitHub URL | Hide GitHub button |
| Case study URL | Hide case study button |
| Long description | Use short description and structured layout |
| Technologies | Hide tech stack area or show “Selected work” style |
| Category | Do not show empty label |
| Results | Hide results section |
| Architecture notes | Hide architecture section |

## 11.3 UI Rule

Never show:

- Empty buttons
- Broken links
- Blank image boxes
- “undefined”
- “null”
- Empty sections with headings only

---

## 12. Testing Requirements

## 12.1 Backend Tests

Laravel tests must cover:

| Test | Required? |
|---|---:|
| Public projects only show published projects | Yes |
| Featured projects only show published featured projects | Yes |
| Project detail loads by slug | Yes |
| Missing optional media/link fields are allowed | Yes |
| Contact form stores valid inquiry | Yes |
| Contact form validates invalid input | Yes |
| Admin login works | Yes |
| Admin routes reject unauthenticated users | Yes |
| Admin can create project | Yes |
| Admin can update project | Yes |
| Admin can publish/unpublish project | Yes |
| Admin can create case study | Recommended |
| Admin can update inquiry status | Recommended |

## 12.2 Frontend Playwright Tests

Playwright tests must cover:

| Flow | Required? |
|---|---:|
| Home page loads | Yes |
| Projects page loads | Yes |
| Project cards display | Yes |
| Project with missing image shows gradient placeholder | Yes |
| Missing project links are hidden | Yes |
| Project detail page opens | Yes |
| Contact form submits | Yes |
| Mobile navigation works | Yes |
| Admin login works | Yes when admin UI exists |
| Admin project create/edit works | Recommended after admin phase |

## 12.3 Manual Design QA

Before deployment, manually check:

- Mobile homepage
- Mobile projects page
- Project cards without images
- Project cards without links
- Contact form errors
- Admin login
- Admin project creation
- Text readability
- Button spacing
- Page loading states
- 404 page

---

## 13. Docker Requirements

## 13.1 Required Local Services

Docker Compose must include:

| Service | Required? | Purpose |
|---|---:|---|
| frontend | Yes | Next.js |
| backend | Yes | Laravel API |
| postgres | Yes | PostgreSQL |
| pgadmin | Optional | Database UI |
| mailpit | Optional | Local email testing |
| redis | Postponed | Queues/cache later |

## 13.2 Environment Requirements

Environment files must be used.

Required examples:

```text
frontend/.env.example
backend/.env.example
```

Required frontend variable:

```text
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Required backend variables:

```text
APP_ENV=local
APP_KEY=
APP_URL=http://localhost:8000
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=secret
```

### Security Rule

Never commit real secrets.

---

## 14. Deployment Requirements

## 14.1 First Deployment: Free / Low-Cost

The first deployment should use low-cost or free-friendly services.

Recommended:

| Layer | Recommended Option |
|---|---|
| Frontend | Vercel |
| Backend | Render, Railway, or Fly.io |
| Database | Supabase, Neon, Railway PostgreSQL, or Render PostgreSQL |
| Media | URL fields first, Cloudinary later |
| Code hosting | GitHub |

### Required Deployment Checks

Before calling deployment complete:

- Public frontend opens.
- API is reachable.
- Projects load from API.
- Contact form works.
- Admin login works.
- Environment variables are configured.
- CORS is configured correctly.
- No secrets are exposed.

## 14.2 AWS Deployment: Postponed

AWS should be postponed until the app is stable.

Later AWS services may include:

- RDS PostgreSQL
- S3
- CloudFront
- ECS Fargate or EC2
- Route 53
- ACM
- Secrets Manager
- CloudWatch

---

## 15. SEO Requirements

## 15.1 Required SEO Basics

The portfolio must include:

- Page titles
- Meta descriptions
- Open Graph metadata
- Clean URLs
- Semantic headings
- Sitemap later
- Robots.txt later

## 15.2 Required Page Metadata

| Page | Required Metadata |
|---|---|
| Home | Title, description, OG image later |
| Projects | Title, description |
| Project detail | Dynamic title and description |
| Case studies | Title, description |
| Case study detail | Dynamic title and description |
| About | Title, description |
| Contact | Title, description |

---

## 16. Performance Requirements

The app must be optimized for:

- Fast first load
- Mobile performance
- Image optimization
- Minimal unnecessary animation
- Clean API calls
- Proper loading states

Required practices:

- Use optimized images where possible.
- Avoid loading heavy animation libraries unnecessarily.
- Keep project cards lightweight.
- Use pagination or limits later if many projects exist.
- Avoid blocking the UI while API data loads.

---

## 17. Security Requirements

The application must follow these security rules:

- No hardcoded secrets.
- Use `.env` files.
- Commit only `.env.example`.
- Hash admin passwords.
- Protect admin routes.
- Validate all backend input.
- Sanitize/escape rendered content.
- Use HTTPS in production.
- Configure CORS carefully.
- Do not expose admin APIs publicly without auth.
- Rate limit contact form later.

---

## 18. Content Requirements

## 18.1 Project Content Quality

Every project should ideally include:

- Clear title
- Short description
- Problem solved
- Technologies used
- What Sufyan built
- Impact or result
- Optional screenshots/video/links

## 18.2 Recommended Initial Project Categories

Suggested categories:

- Laravel Applications
- API Integrations
- ERP / CRM Systems
- FinTech Systems
- Dashboards
- Automation Tools
- AI-Assisted Projects
- Frontend Projects

## 18.3 Recommended Technology Groups

Suggested groups:

- Backend: Laravel, PHP, REST APIs
- Frontend: Next.js, React, TypeScript, Tailwind CSS
- Database: PostgreSQL, MySQL
- DevOps: Docker, GitHub, Deployment
- Testing: Playwright, Laravel Feature Tests
- Integrations: MT5 APIs, payment gateways, third-party APIs
- AI: ChatGPT, Codex, AI-assisted workflows

---

## 19. Required vs Optional vs Postponed Scope

## 19.1 Required for V1

These must be included in the first serious version:

| Area | Requirement |
|---|---|
| Documentation | Project plan and requirements complete |
| Frontend | Next.js + TypeScript + Tailwind |
| Design | Premium responsive public UI |
| Backend | Laravel API |
| Database | PostgreSQL |
| Docker | Local Docker Compose setup |
| Public pages | Home, Projects, Project Detail, About, Contact |
| Projects | Dynamic from API |
| Missing media fallback | Gradient placeholder required |
| Missing links | Buttons hidden automatically |
| Admin auth | Required |
| Admin projects | Create/edit/delete/publish/feature |
| Contact form | Store inquiry in database |
| Testing | Important backend and Playwright tests |
| Deployment | Free/low-cost deployment |
| GitHub | Version control with phase branches |

## 19.2 Optional for V1

These are useful but not required immediately:

| Feature | Notes |
|---|---|
| Case study public pages | Can be added after project pages |
| Case study admin | Can follow project admin |
| Gallery images | Add after basic thumbnail support |
| Video embed | Link support first, embed later |
| Contact email sending | Store inquiry first, email later |
| pgAdmin | Helpful for learning but optional |
| Mailpit | Helpful if email sending is added |
| Filters on projects page | Add after basic listing |
| CV download | Add after content is ready |
| Blog/articles | Not needed for first version |
| Light mode | Optional; dark premium theme first |
| Analytics | Add after deployment |

## 19.3 Postponed

These should not be built at the start:

| Feature | Reason |
|---|---|
| AWS deployment | Too much complexity early |
| Advanced CMS editor | Basic forms are enough first |
| Multi-user roles | One admin is enough |
| Advanced analytics dashboard | Not needed for portfolio V1 |
| Comments/reviews | Not needed |
| Blog system | Can distract from portfolio goal |
| Newsletter | Not needed early |
| Complex media library | URL fields are enough first |
| Payment integration | Not relevant |
| Real-time notifications | Not needed |
| Redis queues | Later if needed |
| Kubernetes | Overkill for this project |
| Microservices | Overkill |
| AI chatbot on portfolio | Optional future feature, not V1 |
| Advanced animations/3D | Risk of looking noisy and slowing site |

---

## 20. Non-Functional Requirements

## 20.1 Maintainability

The project must be easy to maintain.

Requirements:

- Clean folder structure.
- Typed frontend data.
- Backend validation.
- Reusable components.
- Small files where possible.
- Clear naming.
- Documented environment setup.
- Phase-wise implementation.

## 20.2 Scalability

The app does not need enterprise-scale architecture, but it must support future growth.

It should later support:

- More projects
- More case studies
- Media storage
- Cloud deployment
- AWS migration
- SEO improvements
- Better admin features

## 20.3 Reliability

The app must not break when:

- A project has no image.
- A project has no links.
- There are no projects yet.
- There are no case studies yet.
- API returns an error.
- Contact form validation fails.
- User opens on mobile.

---

## 21. Acceptance Criteria

The requirements document is satisfied when:

### Public Site

- Home page looks professional and responsive.
- Projects load from API.
- Project cards look good with or without images.
- Missing buttons are hidden.
- Project detail pages work.
- About page communicates professional profile.
- Contact form stores inquiry.
- Mobile navigation works.

### Admin

- Admin can log in.
- Admin can manage projects.
- Admin can publish/unpublish projects.
- Admin can mark featured projects.
- Admin can view inquiries.
- Admin routes are protected.

### Backend

- Public APIs return only published content.
- Admin APIs require auth.
- Validation works.
- Database supports optional fields.
- Contact inquiries are saved.

### Testing

- Backend feature tests pass for key flows.
- Playwright tests pass for public flows.
- Missing media/link behavior is tested.

### Deployment

- Frontend deployed on low-cost/free service.
- Backend deployed on low-cost/free service.
- Database connected.
- Environment variables configured.
- Public site works using production API.

---

## 22. Development Rules for All Future Coding

All coding tasks must follow these rules:

1. Do not modify unrelated files.
2. Always mention file paths.
3. Keep changes small and phase-wise.
4. Use environment variables for secrets.
5. Never hardcode API keys.
6. Add tests for important flows.
7. Use documentation as the source of truth.
8. After every phase, summarize changed files.
9. After every phase, explain testing steps.
10. If implementation differs from documentation, update documentation first or clearly explain why.

---

## 23. Next Documentation Files

After this document, create the following files before coding:

```text
docs/03-design-system.md
docs/04-database-schema.md
docs/05-api-specification.md
docs/06-frontend-architecture.md
docs/07-docker-setup.md
docs/08-testing-plan.md
docs/09-deployment-plan.md
docs/10-codex-workflow.md
```

Recommended next document:

```text
docs/03-design-system.md
```

This should define colors, typography, spacing, cards, buttons, gradient placeholders, glass effects, animation rules, and responsive layout rules.

---

## 24. Final Scope Decision

For the first production milestone, the project should focus on:

```text
Professional portfolio presentation
Dynamic projects
Optional media/link handling
Admin project management
Contact inquiry storage
Docker local setup
Testing important flows
Free/low-cost deployment
```

The project should not begin with:

```text
AWS
Complex CMS
Advanced animations
Blog system
Newsletter
Multiple roles
Microservices
Kubernetes
AI chatbot
```

This keeps the project professional, manageable, and realistic while still leaving room for future growth.
