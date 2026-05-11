# docs/06-frontend-architecture.md

# Frontend Architecture — Modern AI-Inspired Developer Portfolio

## 1. Purpose

This document defines the frontend architecture for the portfolio application.

The goal is to build a modern, clean, scalable, and production-ready Next.js frontend that connects with the Laravel API and presents the portfolio with a premium AI-inspired design.

This document should guide the implementation of:

- Next.js App Router structure
- TypeScript organization
- Tailwind CSS usage
- Framer Motion animations
- Public portfolio pages
- Admin dashboard pages
- API integration
- Reusable components
- Loading, error, empty, and not-found states
- Frontend testing expectations

---

## 2. Frontend Goals

The frontend should feel like a premium SaaS-style developer portfolio, not a basic CV website.

Primary goals:

1. Present the developer as a serious full-stack Laravel / Next.js engineer.
2. Showcase projects in a polished, professional way.
3. Support optional project images, videos, links, GitHub URLs, and case study links.
4. Use professional fallback UI when media or links are missing.
5. Provide clean public pages for visitors.
6. Provide a secure admin interface for managing content.
7. Keep the UI mobile responsive.
8. Use a consistent design system.
9. Use subtle AI-inspired effects without overdoing animations.
10. Keep code maintainable and easy to extend.

---

## 3. Technology Stack

| Layer | Technology |
|---|---|
| Framework | Next.js |
| Language | TypeScript |
| Styling | Tailwind CSS |
| Animation | Framer Motion |
| API Client | Native `fetch` or lightweight wrapper |
| Forms | React Hook Form later, optional |
| Validation | Zod later, optional |
| Testing | Playwright |
| Deployment | Vercel first |
| Backend | Laravel API |
| Database | PostgreSQL through Laravel API |

---

## 4. Recommended Project Structure

The frontend should live inside:

```text
frontend/
```

Recommended structure:

```text
frontend/
  app/
    layout.tsx
    page.tsx
    loading.tsx
    error.tsx
    not-found.tsx

    about/
      page.tsx

    projects/
      page.tsx
      loading.tsx
      error.tsx
      [slug]/
        page.tsx
        loading.tsx
        error.tsx

    case-studies/
      page.tsx
      loading.tsx
      error.tsx
      [slug]/
        page.tsx
        loading.tsx
        error.tsx

    contact/
      page.tsx

    admin/
      layout.tsx
      page.tsx
      login/
        page.tsx
      projects/
        page.tsx
        new/
          page.tsx
        [id]/
          edit/
            page.tsx
      case-studies/
        page.tsx
        new/
          page.tsx
        [id]/
          edit/
            page.tsx
      inquiries/
        page.tsx
        [id]/
          page.tsx

  components/
    layout/
      Navbar.tsx
      Footer.tsx
      PublicShell.tsx
      AdminShell.tsx
      AdminSidebar.tsx
      AdminHeader.tsx
      MobileMenu.tsx

    home/
      HeroSection.tsx
      FeaturedProjects.tsx
      SkillsSnapshot.tsx
      ExperienceHighlights.tsx
      WorkProcess.tsx
      ContactCTA.tsx

    projects/
      ProjectCard.tsx
      ProjectGrid.tsx
      ProjectFilters.tsx
      ProjectHero.tsx
      ProjectMedia.tsx
      ProjectLinks.tsx
      ProjectTechStack.tsx
      GradientProjectPlaceholder.tsx

    case-studies/
      CaseStudyCard.tsx
      CaseStudyGrid.tsx
      CaseStudyHero.tsx
      CaseStudyContent.tsx

    contact/
      ContactForm.tsx
      ContactInfo.tsx

    admin/
      DashboardStats.tsx
      ProjectTable.tsx
      ProjectForm.tsx
      ProjectMediaManager.tsx
      TechnologySelector.tsx
      CaseStudyTable.tsx
      CaseStudyForm.tsx
      InquiryTable.tsx
      InquiryDetail.tsx

    ui/
      Button.tsx
      Card.tsx
      Badge.tsx
      Container.tsx
      SectionHeading.tsx
      Input.tsx
      Textarea.tsx
      Select.tsx
      EmptyState.tsx
      LoadingState.tsx
      ErrorState.tsx
      ConfirmDialog.tsx
      StatusBadge.tsx

    effects/
      AnimatedGridBackground.tsx
      GradientGlow.tsx
      GlassPanel.tsx
      GlowBorderCard.tsx
      NoiseOverlay.tsx
      MotionWrapper.tsx

  lib/
    api/
      client.ts
      projects.ts
      caseStudies.ts
      contact.ts
      adminAuth.ts
      adminProjects.ts
      adminCaseStudies.ts
      adminInquiries.ts
      adminTechnologies.ts

    types/
      project.ts
      case-study.ts
      technology.ts
      inquiry.ts
      user.ts
      api.ts

    constants/
      navigation.ts
      site.ts
      technologies.ts

    utils/
      cn.ts
      format-date.ts
      slug.ts
      links.ts

  styles/
    globals.css

  tests/
    e2e/
      home.spec.ts
      projects.spec.ts
      project-detail.spec.ts
      contact.spec.ts
      admin-login.spec.ts
```

---

## 5. App Router Strategy

Use the Next.js App Router.

Main route groups:

| Route | Purpose |
|---|---|
| `/` | Homepage |
| `/about` | About/profile page |
| `/projects` | Public project listing |
| `/projects/[slug]` | Project detail page |
| `/case-studies` | Case study listing |
| `/case-studies/[slug]` | Case study detail page |
| `/contact` | Contact page |
| `/admin/login` | Admin login |
| `/admin` | Admin dashboard |
| `/admin/projects` | Project management |
| `/admin/case-studies` | Case study management |
| `/admin/inquiries` | Contact inquiry management |

---

## 6. Layout Architecture

## 6.1 Root Layout

File:

```text
frontend/app/layout.tsx
```

Purpose:

- Define global HTML structure.
- Load global styles.
- Set default metadata.
- Wrap app with global providers if needed.

Responsibilities:

- Use global font.
- Apply body background.
- Include global CSS.
- Do not include admin-specific sidebar here.

---

## 6.2 Public Layout / Shell

File:

```text
frontend/components/layout/PublicShell.tsx
```

Purpose:

Wrap public pages with:

- Navbar
- Main content area
- Footer
- Background effects
- Responsive container behavior

Expected structure:

```text
PublicShell
  Navbar
  main
    page content
  Footer
```

---

## 6.3 Admin Layout / Shell

Files:

```text
frontend/app/admin/layout.tsx
frontend/components/layout/AdminShell.tsx
```

Purpose:

Wrap admin pages with:

- Admin sidebar
- Admin header
- Protected layout behavior
- Dashboard content area

Expected structure:

```text
AdminShell
  AdminSidebar
  AdminHeader
  main
    admin page content
```

Important:

Admin pages should not use the public website Navbar/Footer.

---

## 7. Public Page Architecture

## 7.1 Homepage

Route:

```text
/
```

File:

```text
frontend/app/page.tsx
```

Sections:

1. Hero section
2. Featured projects
3. Skills snapshot
4. Experience highlights
5. Work process
6. Case study preview
7. Contact CTA

Components:

```text
HeroSection
FeaturedProjects
SkillsSnapshot
ExperienceHighlights
WorkProcess
ContactCTA
```

Homepage API usage:

```text
GET /api/projects/featured
GET /api/case-studies
```

The homepage should still look complete if the API returns no featured projects.

---

## 7.2 Projects Page

Route:

```text
/projects
```

File:

```text
frontend/app/projects/page.tsx
```

Purpose:

Display all published projects.

Features:

- Project grid
- Search/filter later
- Category filter later
- Technology filter later
- Empty state if no projects
- Professional placeholders for missing thumbnails

API usage:

```text
GET /api/projects
```

Components:

```text
ProjectGrid
ProjectCard
ProjectFilters
EmptyState
```

---

## 7.3 Project Detail Page

Route:

```text
/projects/[slug]
```

File:

```text
frontend/app/projects/[slug]/page.tsx
```

Purpose:

Show full details of one project.

API usage:

```text
GET /api/projects/{slug}
```

Sections:

1. Project hero
2. Project overview
3. Tech stack
4. Media gallery
5. Project links
6. Related case studies
7. Contact CTA

Components:

```text
ProjectHero
ProjectTechStack
ProjectMedia
ProjectLinks
GradientProjectPlaceholder
```

Fallback rules:

- If no thumbnail, show gradient hero block.
- If no media, hide gallery section.
- If no links, hide link group.
- If no related case study, hide related case study section.

---

## 7.4 Case Studies Page

Route:

```text
/case-studies
```

File:

```text
frontend/app/case-studies/page.tsx
```

Purpose:

Show published case studies.

API usage:

```text
GET /api/case-studies
```

Components:

```text
CaseStudyGrid
CaseStudyCard
EmptyState
```

---

## 7.5 Case Study Detail Page

Route:

```text
/case-studies/[slug]
```

File:

```text
frontend/app/case-studies/[slug]/page.tsx
```

Purpose:

Show long-form case study content.

API usage:

```text
GET /api/case-studies/{slug}
```

Sections:

1. Hero
2. Problem
3. Solution
4. Results
5. Full content
6. Related project
7. Contact CTA

Components:

```text
CaseStudyHero
CaseStudyContent
ProjectCard
ContactCTA
```

Fallback rules:

- If no cover image, use gradient cover.
- If no related project, hide related project section.
- If SEO fields are null, use title and summary.

---

## 7.6 About Page

Route:

```text
/about
```

Purpose:

Tell the professional story.

Sections:

- Short professional bio
- Full-stack development background
- Laravel experience
- API integration expertise
- ERP/CRM/FinTech experience
- AI-assisted development workflow
- Work values

This page can use static content first.

---

## 7.7 Contact Page

Route:

```text
/contact
```

Purpose:

Allow visitors to contact the developer.

API usage:

```text
POST /api/contact
```

Components:

```text
ContactForm
ContactInfo
```

Contact form fields:

- Name
- Email
- Subject
- Message
- Project type, optional

Frontend behavior:

- Show validation messages.
- Show loading state while submitting.
- Show success message after submission.
- Show error message if submission fails.

---

# 8. Admin Page Architecture

## 8.1 Admin Login Page

Route:

```text
/admin/login
```

API usage:

```text
POST /api/admin/login
```

Fields:

- Email
- Password

Behavior:

- Validate required fields.
- Show loading state.
- Show invalid credentials message.
- Redirect to `/admin` after successful login.

---

## 8.2 Admin Dashboard

Route:

```text
/admin
```

API usage:

```text
GET /api/admin/dashboard
```

Components:

```text
DashboardStats
InquiryTable
```

Dashboard cards:

- Total projects
- Published projects
- Draft projects
- Featured projects
- Total case studies
- Unread inquiries

---

## 8.3 Admin Projects Page

Route:

```text
/admin/projects
```

API usage:

```text
GET /api/admin/projects
```

Features:

- Project table
- Search
- Filter by status
- Filter by featured
- Create project button
- Edit action
- Delete action
- Publish/unpublish action
- Feature/unfeature action

Components:

```text
ProjectTable
StatusBadge
ConfirmDialog
```

---

## 8.4 Admin Project Create/Edit

Routes:

```text
/admin/projects/new
/admin/projects/[id]/edit
```

API usage:

```text
POST /api/admin/projects
GET /api/admin/projects/{id}
PATCH /api/admin/projects/{id}
GET /api/admin/technologies
```

Components:

```text
ProjectForm
TechnologySelector
ProjectMediaManager
```

Form fields:

- Title
- Slug
- Short description
- Long description
- Category
- Status
- Thumbnail URL
- Video URL
- Live URL
- GitHub URL
- Case study URL
- Featured
- Sort order
- Started date
- Completed date
- Technologies

---

## 8.5 Admin Case Studies Page

Route:

```text
/admin/case-studies
```

API usage:

```text
GET /api/admin/case-studies
```

Features:

- Case study table
- Status filter
- Search
- Create button
- Edit action
- Delete action
- Publish/unpublish action

Components:

```text
CaseStudyTable
StatusBadge
ConfirmDialog
```

---

## 8.6 Admin Case Study Create/Edit

Routes:

```text
/admin/case-studies/new
/admin/case-studies/[id]/edit
```

API usage:

```text
POST /api/admin/case-studies
GET /api/admin/case-studies/{id}
PATCH /api/admin/case-studies/{id}
GET /api/admin/projects
```

Components:

```text
CaseStudyForm
```

Form fields:

- Project, optional
- Title
- Slug
- Summary
- Problem
- Solution
- Results
- Content
- Cover image URL
- Status
- SEO title
- SEO description
- Published date

---

## 8.7 Admin Inquiries Page

Route:

```text
/admin/inquiries
```

API usage:

```text
GET /api/admin/inquiries
```

Features:

- Inquiry table
- Status filter
- Search
- View detail
- Mark read/replied/archived
- Delete inquiry

Components:

```text
InquiryTable
StatusBadge
ConfirmDialog
```

---

## 8.8 Admin Inquiry Detail

Route:

```text
/admin/inquiries/[id]
```

API usage:

```text
GET /api/admin/inquiries/{id}
PATCH /api/admin/inquiries/{id}/status
DELETE /api/admin/inquiries/{id}
```

Components:

```text
InquiryDetail
```

---

# 9. Component Architecture

## 9.1 UI Components

UI components should be reusable, simple, and consistent.

Recommended components:

| Component | Purpose |
|---|---|
| `Button` | Primary, secondary, ghost actions |
| `Card` | Standard content card |
| `Badge` | Tech/category/status labels |
| `Container` | Page width wrapper |
| `SectionHeading` | Consistent section titles |
| `Input` | Text input |
| `Textarea` | Multi-line input |
| `Select` | Dropdown |
| `EmptyState` | No data UI |
| `LoadingState` | Loading UI |
| `ErrorState` | Error UI |
| `ConfirmDialog` | Delete confirmation |
| `StatusBadge` | Draft/published/read/unread states |

---

## 9.2 Effects Components

Effects must remain subtle and professional.

Recommended components:

| Component | Purpose |
|---|---|
| `AnimatedGridBackground` | Soft AI-style grid background |
| `GradientGlow` | Decorative radial glow |
| `GlassPanel` | Glassmorphism panel |
| `GlowBorderCard` | Subtle glowing card border |
| `NoiseOverlay` | Soft texture overlay |
| `MotionWrapper` | Reusable Framer Motion reveal |

Important:

Do not overuse effects. They should support the content, not dominate it.

---

## 9.3 Project Components

| Component | Purpose |
|---|---|
| `ProjectCard` | Project preview card |
| `ProjectGrid` | Responsive project layout |
| `ProjectFilters` | Search/filter controls |
| `ProjectHero` | Detail page hero |
| `ProjectMedia` | Image/video gallery |
| `ProjectLinks` | Auto-hides missing links |
| `ProjectTechStack` | Technology badges |
| `GradientProjectPlaceholder` | Fallback for missing image |

---

## 9.4 Admin Components

| Component | Purpose |
|---|---|
| `DashboardStats` | Dashboard metric cards |
| `ProjectTable` | Admin project listing |
| `ProjectForm` | Create/edit project |
| `ProjectMediaManager` | Manage project media URLs |
| `TechnologySelector` | Select technologies for project |
| `CaseStudyTable` | Admin case study listing |
| `CaseStudyForm` | Create/edit case study |
| `InquiryTable` | Inquiry list |
| `InquiryDetail` | Full inquiry view |

---

# 10. API Integration Layer

All API calls should be kept inside:

```text
frontend/lib/api/
```

Do not call API endpoints directly inside many components.

Recommended files:

```text
frontend/lib/api/client.ts
frontend/lib/api/projects.ts
frontend/lib/api/caseStudies.ts
frontend/lib/api/contact.ts
frontend/lib/api/adminAuth.ts
frontend/lib/api/adminProjects.ts
frontend/lib/api/adminCaseStudies.ts
frontend/lib/api/adminInquiries.ts
frontend/lib/api/adminTechnologies.ts
```

---

## 10.1 API Client

File:

```text
frontend/lib/api/client.ts
```

Purpose:

Centralize:

- Base API URL
- Request headers
- JSON parsing
- Error handling
- Auth token handling later

Expected environment variable:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Rules:

- Throw consistent errors.
- Do not hardcode API base URL.
- Support GET, POST, PATCH, PUT, DELETE.
- Keep implementation simple first.

---

## 10.2 Public Project API File

File:

```text
frontend/lib/api/projects.ts
```

Functions:

```text
getProjects()
getFeaturedProjects()
getProjectBySlug(slug)
```

---

## 10.3 Public Case Study API File

File:

```text
frontend/lib/api/caseStudies.ts
```

Functions:

```text
getCaseStudies()
getCaseStudyBySlug(slug)
```

---

## 10.4 Contact API File

File:

```text
frontend/lib/api/contact.ts
```

Functions:

```text
submitContactInquiry(payload)
```

---

## 10.5 Admin API Files

Files:

```text
adminAuth.ts
adminProjects.ts
adminCaseStudies.ts
adminInquiries.ts
adminTechnologies.ts
```

Purpose:

Keep admin API calls separate from public API calls.

---

# 11. TypeScript Types

All shared types should be kept inside:

```text
frontend/lib/types/
```

Recommended files:

```text
project.ts
case-study.ts
technology.ts
inquiry.ts
user.ts
api.ts
```

---

## 11.1 Project Types

File:

```text
frontend/lib/types/project.ts
```

Suggested types:

```ts
export type ProjectStatus = "draft" | "published";

export interface ProjectTechnology {
  id: number;
  name: string;
  slug: string;
  category?: string | null;
}

export interface ProjectMedia {
  id: number;
  type: "image" | "video";
  url: string;
  alt_text?: string | null;
  caption?: string | null;
  sort_order: number;
}

export interface ProjectCard {
  id: number;
  title: string;
  slug: string;
  short_description: string;
  category?: string | null;
  thumbnail_url?: string | null;
  video_url?: string | null;
  live_url?: string | null;
  github_url?: string | null;
  case_study_url?: string | null;
  is_featured: boolean;
  technologies: ProjectTechnology[];
}

export interface ProjectDetail extends ProjectCard {
  long_description?: string | null;
  started_at?: string | null;
  completed_at?: string | null;
  media: ProjectMedia[];
}
```

---

## 11.2 Case Study Types

File:

```text
frontend/lib/types/case-study.ts
```

Suggested types:

```ts
export type CaseStudyStatus = "draft" | "published";

export interface CaseStudyCard {
  id: number;
  title: string;
  slug: string;
  summary: string;
  cover_image_url?: string | null;
  published_at?: string | null;
  project?: {
    id: number;
    title: string;
    slug: string;
  } | null;
}

export interface CaseStudyDetail extends CaseStudyCard {
  problem?: string | null;
  solution?: string | null;
  results?: string | null;
  content: string;
  seo_title?: string | null;
  seo_description?: string | null;
}
```

---

## 11.3 API Response Types

File:

```text
frontend/lib/types/api.ts
```

Suggested types:

```ts
export interface ApiResponse<T> {
  data: T;
}

export interface PaginatedApiResponse<T> {
  data: T[];
  meta: {
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
  };
}

export interface ApiErrorResponse {
  message: string;
  errors?: Record<string, string[]>;
}
```

---

# 12. State Management Strategy

For the first version, avoid heavy global state libraries.

Use:

- Server components for public data fetching where possible.
- Local component state for forms and UI toggles.
- Cookies or secure storage for admin auth depending on Sanctum setup.
- Simple React state for admin form interactions.

Do not add Redux/Zustand unless the project genuinely needs it later.

---

# 13. Styling Rules

Use Tailwind CSS with the design system from:

```text
docs/03-design-system.md
```

Frontend styling rules:

1. Use consistent spacing.
2. Use reusable UI components.
3. Avoid one-off styles unless necessary.
4. Keep dark theme premium and readable.
5. Use subtle gradients and glows.
6. Avoid childish colors.
7. Avoid over-animation.
8. Maintain strong contrast.
9. Ensure mobile responsiveness.
10. Use readable typography.

---

# 14. Animation Rules

Use Framer Motion carefully.

Recommended animations:

- Hero text fade-in
- Section reveal on scroll
- Card hover lift
- Subtle glow motion
- Mobile menu transition
- Admin page transitions, minimal

Avoid:

- Excessive bouncing
- Too many particles
- Fast movement
- Distracting background animations
- Animations that reduce readability

---

# 15. Responsive Design Rules

The frontend must work well on:

| Device | Requirement |
|---|---|
| Mobile | Clean stacked layout, readable text, easy navigation |
| Tablet | Balanced two-column layouts where suitable |
| Desktop | Premium spacious layout |
| Large screens | Max-width containers to prevent stretched content |

Common breakpoints:

```text
sm
md
lg
xl
2xl
```

Use Tailwind responsive utilities.

---

# 16. Loading, Error, Empty, and Not Found States

Each major route should handle states professionally.

## 16.1 Loading State

Use skeletons or simple premium loaders.

Files:

```text
loading.tsx
```

Use on:

- Projects page
- Project detail page
- Case studies page
- Case study detail page
- Admin pages

---

## 16.2 Error State

Files:

```text
error.tsx
```

Use for:

- Failed API request
- Server error
- Unexpected rendering issue

Error UI should include:

- Clear message
- Retry option where possible
- Link back to safe page

---

## 16.3 Empty State

Use `EmptyState` component when:

- No projects exist
- No case studies exist
- No inquiries exist
- No filtered results found

---

## 16.4 Not Found State

Use:

```text
frontend/app/not-found.tsx
```

Also use route-level not-found behavior for:

- Project not found
- Case study not found
- Admin record not found

---

# 17. SEO and Metadata

Use Next.js metadata features.

## 17.1 Static Pages

Static metadata for:

- Home
- About
- Projects
- Case Studies
- Contact

## 17.2 Dynamic Pages

Generate metadata from API data for:

```text
/projects/[slug]
/case-studies/[slug]
```

Fallback rules:

| Page | Title | Description |
|---|---|---|
| Project detail | Project title | Short description |
| Case study detail | SEO title or title | SEO description or summary |

If API has no image, use default Open Graph image.

---

# 18. Accessibility Rules

Basic accessibility requirements:

1. Use semantic HTML.
2. Use proper heading hierarchy.
3. Buttons must be real `<button>` elements.
4. Links must be real `<a>` or Next.js `Link`.
5. Images must have alt text.
6. Decorative images can use empty alt text.
7. Form inputs must have labels.
8. Error messages must be clear.
9. Keyboard navigation must work.
10. Color contrast must be readable.

---

# 19. Performance Rules

Performance expectations:

1. Use Next.js image optimization where possible.
2. Avoid loading heavy animation libraries unnecessarily.
3. Keep effects lightweight.
4. Use server-side data fetching for public pages where suitable.
5. Paginate large lists.
6. Avoid unnecessary client components.
7. Use dynamic imports only when helpful.
8. Keep bundle size under control.

---

# 20. Environment Variables

Frontend `.env.local` should include:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Do not store backend secrets in frontend environment variables.

Only expose variables with `NEXT_PUBLIC_` when they are safe for the browser.

---

# 21. Testing Strategy

Use Playwright for end-to-end testing.

Test folder:

```text
frontend/tests/e2e/
```

Recommended tests:

| Test File | Purpose |
|---|---|
| `home.spec.ts` | Homepage loads and key sections appear |
| `projects.spec.ts` | Projects page shows project cards |
| `project-detail.spec.ts` | Project detail page opens correctly |
| `case-studies.spec.ts` | Case studies page loads |
| `contact.spec.ts` | Contact form validates and submits |
| `admin-login.spec.ts` | Admin login works |
| `admin-projects.spec.ts` | Admin can view/create/edit project later |

---

## 21.1 Critical UI Tests

Must test:

1. Project without image shows gradient placeholder.
2. Project without live URL hides Live Demo button.
3. Project without GitHub URL hides GitHub button.
4. Project without video URL hides Watch Video button.
5. Draft projects do not appear publicly.
6. Contact form shows validation errors.
7. Mobile navigation opens and closes.

---

# 22. Build Order

Recommended frontend build order:

## Step 1 — Base Frontend Setup

- Next.js app
- TypeScript
- Tailwind CSS
- Global layout
- Global styles
- Environment variable setup

## Step 2 — Design System Components

- Button
- Card
- Badge
- Container
- SectionHeading
- EmptyState
- LoadingState
- ErrorState
- GradientProjectPlaceholder

## Step 3 — Public Layout

- Navbar
- Footer
- PublicShell
- Background effects

## Step 4 — Public Pages

- Home
- Projects
- Project detail
- Case studies
- Case study detail
- About
- Contact

## Step 5 — API Integration

- API client
- Project API functions
- Case study API functions
- Contact API function
- TypeScript types

## Step 6 — Admin Layout

- AdminShell
- AdminSidebar
- AdminHeader
- Admin login

## Step 7 — Admin Content Management

- Dashboard
- Project table
- Project form
- Case study table
- Case study form
- Inquiry table

## Step 8 — Frontend Testing

- Playwright setup
- Public page tests
- Contact form tests
- Missing media/link tests
- Admin login test

---

# 23. What to Build Now vs Later

## 23.1 Build Now

| Frontend Feature | Include Now? |
|---|---|
| Public layout | Yes |
| Homepage | Yes |
| Projects page | Yes |
| Project detail page | Yes |
| Case studies page | Yes |
| Case study detail page | Yes |
| About page | Yes |
| Contact page | Yes |
| API client | Yes |
| TypeScript types | Yes |
| Basic admin layout | Yes |
| Admin login | Yes |
| Admin project management | Yes |
| Admin case study management | Yes |
| Admin inquiry management | Yes |
| Loading/error/empty states | Yes |
| Mobile navigation | Yes |
| Playwright tests | Yes |

---

## 23.2 Postpone

| Feature | Reason |
|---|---|
| Blog module | Not core portfolio requirement |
| Testimonials module | Can be added after projects |
| Advanced CMS page builder | Too much complexity early |
| File upload UI | URL-based media is enough first |
| Cloudinary upload widget | Add after core app works |
| AWS S3 upload UI | Later AWS phase |
| Analytics dashboard | Not required for MVP |
| Multi-admin roles | One admin is enough first |
| Theme switcher | Dark premium design first |

---

# 24. Acceptance Criteria

This frontend architecture is ready when:

- Folder structure is clearly defined.
- Public pages are clearly defined.
- Admin pages are clearly defined.
- Component responsibilities are clear.
- API integration layer is planned.
- TypeScript types are planned.
- Fallback behavior for missing media and links is documented.
- Loading, error, empty, and not-found states are planned.
- SEO strategy is defined.
- Accessibility expectations are defined.
- Testing expectations are defined.
- Build order is clear.

---

# 25. Next Recommended Document

After this document, create:

```text
docs/07-docker-setup.md
```

That document should define:

- Docker Compose architecture
- Frontend service
- Backend service
- PostgreSQL service
- pgAdmin service
- Mailpit service
- Environment variables
- Local development commands
- Database migration commands
- Troubleshooting notes
