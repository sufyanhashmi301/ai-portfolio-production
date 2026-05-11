# docs/08-testing-plan.md

# Testing Plan — Modern AI-Inspired Developer Portfolio

## 1. Purpose

This document defines the testing strategy for the modern AI-inspired developer portfolio application.

The goal is to make sure the application is reliable, professional, and production-ready before deployment.

Testing should cover:

- Laravel API behavior
- Database rules
- Admin authentication
- Project management
- Case study management
- Contact form submission
- Public frontend pages
- Missing media fallback UI
- Missing link button hiding
- Mobile navigation
- Critical user flows
- Deployment readiness checks

Testing should be added phase-wise, not at the end of the project.

---

## 2. Testing Goals

The testing system should confirm that:

1. Public visitors only see published content.
2. Draft projects and draft case studies are hidden from public pages.
3. Projects without images still look professional.
4. Projects without links do not show broken or empty buttons.
5. Contact form validates and stores submissions.
6. Admin can log in securely.
7. Admin can create, edit, publish, unpublish, feature, and delete projects.
8. Admin can manage case studies.
9. Admin can view and update inquiries.
10. The website works on mobile, tablet, and desktop.
11. API responses follow the documented structure.
12. Important flows do not break during future updates.

---

## 3. Testing Stack

| Area | Tool |
|---|---|
| Backend API tests | Laravel Feature Tests |
| Backend unit tests | PHPUnit / Pest, optional |
| Frontend E2E tests | Playwright |
| API manual testing | Postman / Insomnia, optional |
| Static checks | TypeScript, ESLint |
| Build checks | Next.js build, Laravel tests |
| Future CI | GitHub Actions |

Recommended first version:

- Laravel Feature Tests
- Playwright E2E Tests
- TypeScript checks
- Frontend build checks

---

## 4. Testing Philosophy

Use practical tests that protect important behavior.

Do not over-test basic framework behavior.

Focus on:

- Business rules
- Public visibility rules
- Optional media/link behavior
- Authentication protection
- Admin CRUD flows
- Contact form reliability
- User-facing pages

Good tests should answer:

> If this test fails, would the portfolio break for a visitor, admin, or deployment?

If yes, the test is useful.

---

# 5. Backend Testing — Laravel

## 5.1 Backend Test Location

Laravel tests should live in:

```text
backend/tests/
  Feature/
  Unit/
```

Recommended first tests:

```text
backend/tests/Feature/
  PublicProjectsTest.php
  PublicCaseStudiesTest.php
  ContactInquiryTest.php
  AdminAuthTest.php
  AdminProjectsTest.php
  AdminCaseStudiesTest.php
  AdminInquiriesTest.php
```

---

## 5.2 Public Projects API Tests

File:

```text
backend/tests/Feature/PublicProjectsTest.php
```

## Test 1 — Published Projects Are Returned

Purpose:

Ensure public project listing returns only published projects.

Scenario:

1. Create one published project.
2. Create one draft project.
3. Request:

```http
GET /api/projects
```

Expected:

- Response status is `200`.
- Published project is visible.
- Draft project is not visible.

---

## Test 2 — Featured Projects Are Returned

Purpose:

Ensure featured endpoint returns only published featured projects.

Scenario:

1. Create published featured project.
2. Create published non-featured project.
3. Create draft featured project.
4. Request:

```http
GET /api/projects/featured
```

Expected:

- Response status is `200`.
- Published featured project is visible.
- Published non-featured project is hidden.
- Draft featured project is hidden.

---

## Test 3 — Project Detail Loads by Slug

Purpose:

Ensure public detail page API works for published projects.

Scenario:

1. Create published project with slug.
2. Request:

```http
GET /api/projects/{slug}
```

Expected:

- Response status is `200`.
- Response contains project title.
- Response contains slug.
- Response contains technologies if attached.

---

## Test 4 — Draft Project Detail Returns 404

Purpose:

Prevent draft content from being public.

Scenario:

1. Create draft project.
2. Request:

```http
GET /api/projects/{draft-slug}
```

Expected:

- Response status is `404`.

---

## Test 5 — Project Allows Missing Optional Fields

Purpose:

Ensure project can exist without image, video, GitHub, live URL, or case study link.

Scenario:

1. Create project with required fields only.
2. Request public listing.

Expected:

- Response status is `200`.
- Optional fields are null.
- API does not fail.

---

## 5.3 Public Case Studies API Tests

File:

```text
backend/tests/Feature/PublicCaseStudiesTest.php
```

## Test 1 — Published Case Studies Are Returned

Scenario:

1. Create one published case study.
2. Create one draft case study.
3. Request:

```http
GET /api/case-studies
```

Expected:

- Published case study is visible.
- Draft case study is hidden.

---

## Test 2 — Case Study Detail Loads by Slug

Scenario:

1. Create published case study.
2. Request:

```http
GET /api/case-studies/{slug}
```

Expected:

- Response status is `200`.
- Response contains title, summary, and content.

---

## Test 3 — Draft Case Study Detail Returns 404

Scenario:

1. Create draft case study.
2. Request:

```http
GET /api/case-studies/{draft-slug}
```

Expected:

- Response status is `404`.

---

## Test 4 — Case Study Can Be Independent

Purpose:

Ensure a case study can exist without a related project.

Scenario:

1. Create published case study with `project_id = null`.
2. Request case study detail.

Expected:

- Response status is `200`.
- `project` is null.
- API does not fail.

---

## 5.4 Contact Inquiry API Tests

File:

```text
backend/tests/Feature/ContactInquiryTest.php
```

## Test 1 — Valid Contact Inquiry Is Stored

Request:

```http
POST /api/contact
```

Payload:

```json
{
  "name": "Client Name",
  "email": "client@example.com",
  "subject": "Project inquiry",
  "message": "I want to discuss a Laravel project.",
  "project_type": "Laravel API"
}
```

Expected:

- Response status is `200` or `201`.
- Response contains success message.
- Inquiry exists in database.

---

## Test 2 — Invalid Email Is Rejected

Payload:

```json
{
  "name": "Client Name",
  "email": "wrong-email",
  "message": "I want to discuss a project."
}
```

Expected:

- Response status is `422`.
- Validation error exists for `email`.

---

## Test 3 — Short Message Is Rejected

Payload:

```json
{
  "name": "Client Name",
  "email": "client@example.com",
  "message": "Hi"
}
```

Expected:

- Response status is `422`.
- Validation error exists for `message`.

---

## Test 4 — Name Is Required

Expected:

- Missing `name` returns `422`.

---

## 5.5 Admin Authentication Tests

File:

```text
backend/tests/Feature/AdminAuthTest.php
```

## Test 1 — Admin Can Login With Valid Credentials

Scenario:

1. Create admin user.
2. Send login request.

Expected:

- Response status is `200`.
- Response contains user data.
- Token or session authentication is created.

---

## Test 2 — Invalid Credentials Are Rejected

Expected:

- Response status is `401`.
- Response contains invalid credentials message.

---

## Test 3 — Authenticated Admin Can Access Me Endpoint

Request:

```http
GET /api/admin/me
```

Expected:

- Response status is `200`.
- Response contains admin name, email, and role.

---

## Test 4 — Guest Cannot Access Admin Me Endpoint

Expected:

- Response status is `401`.

---

## 5.6 Admin Project Tests

File:

```text
backend/tests/Feature/AdminProjectsTest.php
```

## Test 1 — Guest Cannot List Admin Projects

Request:

```http
GET /api/admin/projects
```

Expected:

- Response status is `401`.

---

## Test 2 — Admin Can List Projects

Expected:

- Response status is `200`.
- Response includes draft and published projects.

---

## Test 3 — Admin Can Create Project

Payload includes:

- Title
- Slug
- Short description
- Status

Expected:

- Response status is `201`.
- Project exists in database.

---

## Test 4 — Admin Can Update Project

Expected:

- Response status is `200`.
- Updated title exists in database.

---

## Test 5 — Admin Can Publish Project

Request:

```http
PATCH /api/admin/projects/{id}/publish
```

Expected:

- Response status is `200`.
- Project status becomes `published`.

---

## Test 6 — Admin Can Unpublish Project

Request:

```http
PATCH /api/admin/projects/{id}/unpublish
```

Expected:

- Response status is `200`.
- Project status becomes `draft`.

---

## Test 7 — Admin Can Feature Project

Request:

```http
PATCH /api/admin/projects/{id}/feature
```

Expected:

- `is_featured = true`.

---

## Test 8 — Admin Can Unfeature Project

Request:

```http
PATCH /api/admin/projects/{id}/unfeature
```

Expected:

- `is_featured = false`.

---

## Test 9 — Admin Can Delete Project

Expected:

- Response status is `200` or `204`.
- Project is deleted or soft deleted.

---

## Test 10 — Required Project Fields Are Validated

Expected:

- Missing title returns `422`.
- Missing slug returns `422`.
- Missing short description returns `422`.
- Invalid status returns `422`.

---

## 5.7 Admin Project Media Tests

Recommended file:

```text
backend/tests/Feature/AdminProjectMediaTest.php
```

## Test 1 — Admin Can Add Project Media

Expected:

- Media record is created.
- Media belongs to project.

---

## Test 2 — Invalid Media Type Is Rejected

Expected:

- Type other than `image` or `video` returns `422`.

---

## Test 3 — Invalid URL Is Rejected

Expected:

- Invalid URL returns `422`.

---

## Test 4 — Admin Can Delete Project Media

Expected:

- Media record is removed.

---

## 5.8 Admin Technology Tests

Recommended file:

```text
backend/tests/Feature/AdminTechnologiesTest.php
```

Tests:

1. Admin can list technologies.
2. Admin can create technology.
3. Admin can update technology.
4. Duplicate slug is rejected.
5. Technology attached to projects cannot be deleted if protected deletion is implemented.

---

## 5.9 Admin Case Study Tests

File:

```text
backend/tests/Feature/AdminCaseStudiesTest.php
```

Tests:

1. Guest cannot access admin case studies.
2. Admin can list case studies.
3. Admin can create case study.
4. Admin can update case study.
5. Admin can publish case study.
6. Publishing sets `published_at` if empty.
7. Admin can unpublish case study.
8. Admin can delete case study.
9. Case study can be created without project.
10. Required fields are validated.

---

## 5.10 Admin Inquiry Tests

File:

```text
backend/tests/Feature/AdminInquiriesTest.php
```

Tests:

1. Guest cannot list inquiries.
2. Admin can list inquiries.
3. Admin can view inquiry detail.
4. Admin can update inquiry status.
5. Invalid inquiry status is rejected.
6. Admin can delete inquiry.

---

# 6. Frontend Testing — Playwright

## 6.1 Frontend Test Location

Recommended location:

```text
frontend/tests/e2e/
```

Suggested test files:

```text
home.spec.ts
projects.spec.ts
project-detail.spec.ts
case-studies.spec.ts
case-study-detail.spec.ts
contact.spec.ts
mobile-navigation.spec.ts
admin-login.spec.ts
admin-projects.spec.ts
```

---

## 6.2 Homepage Tests

File:

```text
frontend/tests/e2e/home.spec.ts
```

Tests:

1. Homepage loads successfully.
2. Hero section is visible.
3. Main call-to-action buttons are visible.
4. Featured projects section appears.
5. Skills snapshot section appears.
6. Contact CTA appears.
7. Page has no obvious broken layout on mobile.

---

## 6.3 Projects Page Tests

File:

```text
frontend/tests/e2e/projects.spec.ts
```

Tests:

1. Projects page loads.
2. Project cards are visible when projects exist.
3. Empty state appears when no projects exist.
4. Category or technology badges appear.
5. Project cards link to project detail pages.

---

## 6.4 Missing Image Fallback Test

Critical test.

Purpose:

Ensure project cards still look professional when image is missing.

Scenario:

1. Seed project with `thumbnail_url = null`.
2. Open projects page.
3. Find that project card.

Expected:

- No broken image appears.
- Gradient placeholder appears.
- Project title is visible.
- Card layout remains clean.

---

## 6.5 Missing Link Button Tests

Critical tests.

Scenario:

Seed a project with:

```text
live_url = null
github_url = null
video_url = null
case_study_url = null
```

Expected:

- Live Demo button is not visible.
- GitHub button is not visible.
- Watch Video button is not visible.
- Case Study button is not visible.
- Card still looks complete.

---

## 6.6 Project Detail Page Tests

File:

```text
frontend/tests/e2e/project-detail.spec.ts
```

Tests:

1. Project detail page loads by slug.
2. Project title appears.
3. Tech stack appears.
4. Missing media section is hidden.
5. Missing links are hidden.
6. Not found project shows 404 UI.

---

## 6.7 Case Studies Page Tests

File:

```text
frontend/tests/e2e/case-studies.spec.ts
```

Tests:

1. Case studies page loads.
2. Case study cards are visible when data exists.
3. Empty state appears when no case studies exist.
4. Case study card links to detail page.

---

## 6.8 Case Study Detail Tests

File:

```text
frontend/tests/e2e/case-study-detail.spec.ts
```

Tests:

1. Case study detail page loads by slug.
2. Title is visible.
3. Summary is visible.
4. Problem section appears if available.
5. Solution section appears if available.
6. Results section appears if available.
7. Related project section is hidden if no project is linked.
8. Draft case study is not accessible publicly.

---

## 6.9 Contact Form Tests

File:

```text
frontend/tests/e2e/contact.spec.ts
```

Tests:

1. Contact page loads.
2. Form fields are visible.
3. Required field validation appears.
4. Invalid email validation appears.
5. Short message validation appears.
6. Valid form submission shows success message.
7. API error shows user-friendly error message.

---

## 6.10 Mobile Navigation Tests

File:

```text
frontend/tests/e2e/mobile-navigation.spec.ts
```

Tests:

1. Mobile menu button appears on small screens.
2. Menu opens when clicked.
3. Menu closes when close button is clicked.
4. Navigation links work.
5. Menu does not cover content incorrectly.
6. Body scrolling behavior is acceptable.

---

## 6.11 Admin Login Tests

File:

```text
frontend/tests/e2e/admin-login.spec.ts
```

Tests:

1. Admin login page loads.
2. Empty login form shows validation.
3. Invalid credentials show error.
4. Valid credentials redirect to admin dashboard.
5. Guest visiting `/admin` redirects to `/admin/login`.

---

## 6.12 Admin Projects Tests

File:

```text
frontend/tests/e2e/admin-projects.spec.ts
```

Tests:

1. Admin projects page loads after login.
2. Project table appears.
3. Admin can open create project form.
4. Required field errors appear.
5. Admin can create project.
6. Admin can edit project.
7. Admin can publish/unpublish project.
8. Admin can feature/unfeature project.

These tests can be added after admin UI is implemented.

---

# 7. Static and Build Checks

## 7.1 TypeScript Check

Run:

```bash
docker compose exec frontend npm run typecheck
```

Expected:

- No TypeScript errors.

---

## 7.2 Lint Check

Run:

```bash
docker compose exec frontend npm run lint
```

Expected:

- No lint errors in changed files.

---

## 7.3 Frontend Build Check

Run:

```bash
docker compose exec frontend npm run build
```

Expected:

- Build completes successfully.
- No missing environment variable errors.
- No broken imports.

---

## 7.4 Backend Test Check

Run:

```bash
docker compose exec backend php artisan test
```

Expected:

- All Laravel tests pass.

---

# 8. Test Data Strategy

## 8.1 Backend Factories

Create factories for:

| Factory | Purpose |
|---|---|
| `UserFactory` | Admin user |
| `ProjectFactory` | Draft and published projects |
| `ProjectMediaFactory` | Project images/videos |
| `TechnologyFactory` | Tech stack tags |
| `CaseStudyFactory` | Draft and published case studies |
| `ContactInquiryFactory` | Contact messages |

---

## 8.2 Seeded Local Data

Seeders should create:

1. One admin user.
2. Core technologies.
3. 3–5 sample projects.
4. At least one project without image.
5. At least one project without live/GitHub/video links.
6. 1–2 sample case studies.
7. A few contact inquiries.

This data helps test the real frontend visually.

---

## 8.3 Required Edge Case Records

Create test records for:

| Record | Purpose |
|---|---|
| Published project with all fields | Full UI test |
| Published project without image | Fallback placeholder test |
| Published project without links | Hide buttons test |
| Draft project | Public hiding test |
| Published case study with project | Related project test |
| Published case study without project | Independent case study test |
| Draft case study | Public hiding test |

---

# 9. Manual QA Checklist

Manual QA should be done before deployment.

## 9.1 Public Website Checklist

| Check | Pass/Fail |
|---|---|
| Homepage loads correctly |  |
| Hero section looks premium |  |
| Navbar links work |  |
| Mobile menu works |  |
| Featured projects appear |  |
| Projects page loads |  |
| Project cards look good |  |
| Missing image fallback works |  |
| Missing buttons are hidden |  |
| Project detail page works |  |
| Case studies page works |  |
| Case study detail page works |  |
| About page looks professional |  |
| Contact page works |  |
| Footer links work |  |
| 404 page works |  |

---

## 9.2 Admin Checklist

| Check | Pass/Fail |
|---|---|
| Admin login works |  |
| Invalid login shows error |  |
| Admin dashboard loads |  |
| Project list loads |  |
| Create project works |  |
| Edit project works |  |
| Publish/unpublish works |  |
| Feature/unfeature works |  |
| Delete confirmation works |  |
| Case study list loads |  |
| Create case study works |  |
| Edit case study works |  |
| Publish/unpublish case study works |  |
| Inquiry list loads |  |
| Inquiry detail loads |  |
| Inquiry status update works |  |

---

## 9.3 Responsive Design Checklist

Test at:

| Screen | Width |
|---|---|
| Small mobile | 360px |
| Large mobile | 430px |
| Tablet | 768px |
| Laptop | 1366px |
| Desktop | 1440px+ |

Check:

- No horizontal scrolling.
- Text remains readable.
- Buttons are easy to tap.
- Cards stack properly.
- Navigation works.
- Admin tables remain usable.

---

## 9.4 Browser Checklist

Test at minimum:

| Browser | Priority |
|---|---|
| Chrome | Required |
| Edge | Required |
| Firefox | Recommended |
| Safari | Later if available |

---

# 10. Accessibility Testing

Basic accessibility checks:

1. Keyboard navigation works.
2. Buttons and links are focusable.
3. Forms have labels.
4. Error messages are readable.
5. Color contrast is acceptable.
6. Images have alt text.
7. Decorative images use empty alt text.
8. Heading order is logical.
9. Mobile menu can be closed using keyboard.
10. Focus states are visible.

Optional later:

- Use Playwright accessibility checks.
- Use Lighthouse.
- Use axe-core.

---

# 11. Performance Testing

Before deployment, check:

1. Homepage loads quickly.
2. Project images are optimized.
3. No unnecessary large JavaScript bundles.
4. Animations are smooth.
5. API responses are not overloaded.
6. Lists are paginated.
7. No console errors.
8. No broken network requests.

Tools:

- Chrome Lighthouse
- Next.js build output
- Browser DevTools Network tab

---

# 12. Security Testing

## 12.1 Public Security Checks

| Check | Expected |
|---|---|
| Draft projects are hidden | Yes |
| Draft case studies are hidden | Yes |
| Contact form validates input | Yes |
| Contact form is rate-limited | Yes |
| API does not expose stack traces | Yes |

---

## 12.2 Admin Security Checks

| Check | Expected |
|---|---|
| Guest cannot access admin APIs | 401 |
| Guest cannot access admin pages | Redirect to login |
| Invalid login is rejected | 401 |
| Password hash is never exposed | Yes |
| Admin token/session is protected | Yes |
| Logout invalidates session/token | Yes |

---

# 13. Deployment Readiness Tests

Before free/low-cost deployment:

## 13.1 Backend

Run:

```bash
docker compose exec backend php artisan test
```

Check:

- All tests pass.
- Migrations work.
- Seeders work.
- API endpoints return correct data.
- Contact form stores inquiry.
- CORS works with deployed frontend domain.

---

## 13.2 Frontend

Run:

```bash
docker compose exec frontend npm run typecheck
docker compose exec frontend npm run lint
docker compose exec frontend npm run build
```

Check:

- No TypeScript errors.
- No build errors.
- No missing environment variables.
- Public pages render.
- Admin pages render.

---

## 13.3 E2E

Run:

```bash
docker compose exec frontend npx playwright test
```

Check:

- Core user flows pass.
- Project fallback behavior passes.
- Contact form passes.
- Admin login passes.

---

# 14. Future CI Strategy

CI should be added later using GitHub Actions.

Recommended CI pipeline:

1. Install frontend dependencies.
2. Run frontend typecheck.
3. Run frontend lint.
4. Run frontend build.
5. Install backend dependencies.
6. Run backend tests.
7. Run Playwright tests later if environment supports full stack.

Do not add CI before the local test setup is stable.

---

# 15. Suggested GitHub Actions Workflow Later

Future file:

```text
.github/workflows/ci.yml
```

Future checks:

```text
frontend typecheck
frontend lint
frontend build
backend tests
```

Playwright can be added after stable deployment.

---

# 16. Testing Commands Summary

## Backend

```bash
docker compose exec backend php artisan test
```

## Frontend TypeScript

```bash
docker compose exec frontend npm run typecheck
```

## Frontend Lint

```bash
docker compose exec frontend npm run lint
```

## Frontend Build

```bash
docker compose exec frontend npm run build
```

## Playwright

```bash
docker compose exec frontend npx playwright test
```

## Playwright UI Mode

```bash
docker compose exec frontend npx playwright test --ui
```

---

# 17. Development Rule After Every Phase

After every implementation phase, document:

1. Files changed.
2. Features added.
3. Tests added.
4. Commands run.
5. Test results.
6. Any known issue.
7. Next recommended task.

This matches the project rule:

> Keep changes small, phase-wise, and testable.

---

# 18. What to Test Now vs Later

## 18.1 Test Now

| Test Area | Include Now? |
|---|---|
| Public project API | Yes |
| Featured project API | Yes |
| Public case study API | Yes |
| Contact form API | Yes |
| Admin auth API | Yes |
| Admin project CRUD | Yes |
| Admin case study CRUD | Yes |
| Inquiry management | Yes |
| Homepage E2E | Yes |
| Projects E2E | Yes |
| Missing image fallback | Yes |
| Missing links hidden | Yes |
| Contact form E2E | Yes |
| Mobile navigation | Yes |

---

## 18.2 Test Later

| Test Area | Reason |
|---|---|
| Blog tests | Blog is postponed |
| Newsletter tests | Newsletter is postponed |
| Testimonials tests | Testimonials are postponed |
| AWS deployment tests | Later AWS phase |
| S3 upload tests | File upload postponed |
| Advanced admin roles | Multi-role admin postponed |
| Analytics dashboard | Analytics postponed |
| Visual regression testing | Add after UI stabilizes |

---

# 19. Acceptance Criteria

This testing plan is ready when:

- Backend feature tests are clearly defined.
- Frontend Playwright tests are clearly defined.
- Missing media fallback tests are included.
- Missing link button tests are included.
- Contact form tests are included.
- Admin auth tests are included.
- Admin CRUD tests are included.
- Manual QA checklist is included.
- Responsive design checklist is included.
- Security testing expectations are included.
- Deployment readiness commands are included.
- Future CI strategy is documented.

---

# 20. Next Recommended Document

After this document, create:

```text
docs/09-deployment-plan.md
```

That document should define:

- Free/low-cost deployment strategy
- Vercel frontend deployment
- Laravel backend deployment options
- PostgreSQL hosting options
- Environment variables
- CORS setup
- Domain setup
- Production checklist
- Later AWS deployment plan
