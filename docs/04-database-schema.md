# docs/04-database-schema.md

# Database Schema — Modern AI-Inspired Developer Portfolio

## 1. Purpose of This Document

This document defines the database structure for the portfolio application before backend implementation starts.

The goal is to design a clean, scalable, PostgreSQL-friendly schema for:

- Public portfolio projects
- Optional project images, videos, and external links
- Case studies
- Technologies / skills
- Admin authentication
- Contact inquiries
- Future settings and content management

This file should be used as the source of truth when creating Laravel migrations, models, factories, seeders, validation rules, and API resources.

---

## 2. Database Design Principles

The schema should follow these rules:

1. Use PostgreSQL as the main database.
2. Use Laravel migrations for all database changes.
3. Keep required fields minimal so content can be added gradually.
4. Allow project media and links to be optional.
5. Never force a project to have an image, video, live URL, GitHub URL, or case study.
6. Use professional fallback UI on the frontend when optional content is missing.
7. Use slugs for public detail pages.
8. Use status fields for draft and published content.
9. Keep admin-only data protected behind authentication.
10. Avoid storing secrets in the database unless encrypted and necessary.
11. Use timestamps consistently.
12. Use soft deletes only where useful, not everywhere by default.

---

## 3. Main Tables Overview

The first production version should include these tables:

| Table | Purpose |
|---|---|
| `users` | Admin authentication |
| `projects` | Portfolio project records |
| `project_media` | Optional project images/videos |
| `technologies` | Reusable technology/skill tags |
| `project_technology` | Many-to-many relation between projects and technologies |
| `case_studies` | Detailed project/business case studies |
| `contact_inquiries` | Contact form submissions |
| `settings` | Optional site-wide settings for later |

---

## 4. Entity Relationship Summary

High-level relationships:

```text
users
  └── admin user manages content

projects
  ├── has many project_media
  ├── belongs to many technologies
  └── has many / one related case_studies

technologies
  └── belongs to many projects

case_studies
  └── optionally belongs to project

contact_inquiries
  └── standalone user-submitted messages

settings
  └── standalone key-value configuration
```

---

## 5. Table: `users`

## 5.1 Purpose

Stores admin users who can log in and manage the portfolio content.

For the first version, one admin user is enough.

## 5.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `name` | `varchar(255)` | Yes | Admin name |
| `email` | `varchar(255)` | Yes | Unique email |
| `email_verified_at` | `timestamp` | No | Default Laravel field |
| `password` | `varchar(255)` | Yes | Hashed password |
| `role` | `varchar(50)` | Yes | Default: `admin` |
| `remember_token` | `varchar(100)` | No | Default Laravel field |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 5.3 Indexes

| Index | Columns | Type |
|---|---|---|
| `users_email_unique` | `email` | Unique |

## 5.4 Notes

- Password must always be hashed.
- Admin credentials should not be hardcoded in code.
- First admin user can be created through a seeder using environment variables.

Example environment variables:

```env
ADMIN_NAME="Sufyan"
ADMIN_EMAIL="admin@example.com"
ADMIN_PASSWORD="change-this-password"
```

---

# 6. Table: `projects`

## 6.1 Purpose

Stores portfolio projects shown on the public website and managed from the admin panel.

Projects must support incomplete content gracefully. A project can exist without image, video, live link, GitHub link, or case study.

## 6.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `title` | `varchar(255)` | Yes | Project title |
| `slug` | `varchar(255)` | Yes | Unique public URL slug |
| `short_description` | `text` | Yes | Used on cards and listing pages |
| `long_description` | `text` | No | Used on detail page |
| `category` | `varchar(100)` | No | Example: `ERP`, `CRM`, `FinTech`, `Dashboard`, `API` |
| `status` | `varchar(50)` | Yes | `draft` or `published` |
| `thumbnail_url` | `text` | No | Optional project image |
| `video_url` | `text` | No | Optional video/demo URL |
| `live_url` | `text` | No | Optional live project URL |
| `github_url` | `text` | No | Optional GitHub repository URL |
| `case_study_url` | `text` | No | Optional internal or external case study URL |
| `is_featured` | `boolean` | Yes | Default: `false` |
| `sort_order` | `integer` | Yes | Default: `0` |
| `started_at` | `date` | No | Optional project start date |
| `completed_at` | `date` | No | Optional project completion date |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 6.3 Recommended Status Values

| Value | Meaning |
|---|---|
| `draft` | Hidden from public website |
| `published` | Visible on public website |

## 6.4 Indexes

| Index | Columns | Type |
|---|---|---|
| `projects_slug_unique` | `slug` | Unique |
| `projects_status_index` | `status` | Normal |
| `projects_is_featured_index` | `is_featured` | Normal |
| `projects_sort_order_index` | `sort_order` | Normal |

## 6.5 Frontend Rules

The frontend must follow these rules:

| Condition | Frontend Behavior |
|---|---|
| `thumbnail_url` is null | Show professional gradient placeholder |
| `video_url` is null | Hide video button |
| `live_url` is null | Hide live demo button |
| `github_url` is null | Hide GitHub button |
| `case_study_url` is null | Hide case study button |
| `status = draft` | Do not show publicly |
| `is_featured = true` and `status = published` | Show in featured projects section |

## 6.6 Example Project Categories

Initial categories can include:

- Laravel Application
- Full-Stack Web App
- SaaS Dashboard
- ERP / CRM
- FinTech
- API Integration
- Automation
- AI-Assisted Tool
- School Management System
- E-commerce

These should remain flexible and can later be moved into a dedicated `categories` table if needed.

---

# 7. Table: `project_media`

## 7.1 Purpose

Stores optional media assets for each project.

A project can have multiple images or videos, but media should not be required.

## 7.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `project_id` | `bigint` | Yes | Foreign key to `projects.id` |
| `type` | `varchar(50)` | Yes | `image` or `video` |
| `url` | `text` | Yes | Media URL |
| `alt_text` | `varchar(255)` | No | For accessibility |
| `caption` | `varchar(255)` | No | Optional caption |
| `sort_order` | `integer` | Yes | Default: `0` |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 7.3 Recommended Type Values

| Value | Meaning |
|---|---|
| `image` | Screenshot, preview image, UI image |
| `video` | Demo video or walkthrough |

## 7.4 Foreign Key

| Column | References | On Delete |
|---|---|---|
| `project_id` | `projects.id` | Cascade |

## 7.5 Indexes

| Index | Columns | Type |
|---|---|---|
| `project_media_project_id_index` | `project_id` | Normal |
| `project_media_type_index` | `type` | Normal |
| `project_media_sort_order_index` | `sort_order` | Normal |

## 7.6 Notes

- First version can use URL fields only.
- File upload can be added later using Cloudinary, S3, or Laravel storage.
- Do not block project publishing if media is missing.

---

# 8. Table: `technologies`

## 8.1 Purpose

Stores reusable technology tags such as Laravel, Next.js, PostgreSQL, Docker, Playwright, AWS, etc.

This keeps project tech stacks clean and searchable.

## 8.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `name` | `varchar(100)` | Yes | Technology name |
| `slug` | `varchar(120)` | Yes | Unique slug |
| `category` | `varchar(100)` | No | Example: frontend, backend, database |
| `icon` | `varchar(255)` | No | Optional icon name |
| `sort_order` | `integer` | Yes | Default: `0` |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 8.3 Recommended Technology Categories

| Category | Examples |
|---|---|
| `frontend` | Next.js, React, TypeScript, Tailwind CSS |
| `backend` | Laravel, PHP |
| `database` | PostgreSQL, MySQL |
| `devops` | Docker, GitHub Actions, AWS |
| `testing` | Playwright, PHPUnit |
| `api` | REST API, Sanctum |
| `ai` | ChatGPT, Codex, AI-assisted development |
| `realtime` | Pusher, WebSockets, Laravel Reverb |

## 8.4 Indexes

| Index | Columns | Type |
|---|---|---|
| `technologies_slug_unique` | `slug` | Unique |
| `technologies_category_index` | `category` | Normal |
| `technologies_sort_order_index` | `sort_order` | Normal |

---

# 9. Pivot Table: `project_technology`

## 9.1 Purpose

Creates many-to-many relationship between projects and technologies.

One project can use many technologies, and one technology can belong to many projects.

## 9.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `project_id` | `bigint` | Yes | Foreign key to `projects.id` |
| `technology_id` | `bigint` | Yes | Foreign key to `technologies.id` |

## 9.3 Foreign Keys

| Column | References | On Delete |
|---|---|---|
| `project_id` | `projects.id` | Cascade |
| `technology_id` | `technologies.id` | Cascade |

## 9.4 Indexes

| Index | Columns | Type |
|---|---|---|
| `project_technology_unique` | `project_id`, `technology_id` | Unique |
| `project_technology_project_id_index` | `project_id` | Normal |
| `project_technology_technology_id_index` | `technology_id` | Normal |

## 9.5 Laravel Relationship

Expected relationship:

```php
// Project model
public function technologies()
{
    return $this->belongsToMany(Technology::class);
}

// Technology model
public function projects()
{
    return $this->belongsToMany(Project::class);
}
```

---

# 10. Table: `case_studies`

## 10.1 Purpose

Stores long-form case studies for selected projects.

A case study explains the problem, solution, architecture decisions, technical work, challenges, and results.

## 10.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `project_id` | `bigint` | No | Nullable foreign key to `projects.id` |
| `title` | `varchar(255)` | Yes | Case study title |
| `slug` | `varchar(255)` | Yes | Unique public slug |
| `summary` | `text` | Yes | Short summary for cards |
| `problem` | `text` | No | Problem context |
| `solution` | `text` | No | Solution summary |
| `results` | `text` | No | Outcomes / impact |
| `content` | `longText` | Yes | Full case study content |
| `cover_image_url` | `text` | No | Optional cover image |
| `status` | `varchar(50)` | Yes | `draft` or `published` |
| `seo_title` | `varchar(255)` | No | Optional SEO title |
| `seo_description` | `text` | No | Optional SEO description |
| `published_at` | `timestamp` | No | Set when published |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 10.3 Foreign Key

| Column | References | On Delete |
|---|---|---|
| `project_id` | `projects.id` | Set null |

## 10.4 Indexes

| Index | Columns | Type |
|---|---|---|
| `case_studies_slug_unique` | `slug` | Unique |
| `case_studies_project_id_index` | `project_id` | Normal |
| `case_studies_status_index` | `status` | Normal |
| `case_studies_published_at_index` | `published_at` | Normal |

## 10.5 Frontend Rules

| Condition | Frontend Behavior |
|---|---|
| `cover_image_url` is null | Use professional gradient cover |
| `project_id` is null | Show as independent case study |
| `status = draft` | Hide from public website |
| `status = published` | Show publicly |
| `seo_title` is null | Use `title` as fallback |
| `seo_description` is null | Use `summary` as fallback |

---

# 11. Table: `contact_inquiries`

## 11.1 Purpose

Stores messages submitted through the contact form.

This allows the admin to review inquiries even if email delivery fails.

## 11.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `name` | `varchar(255)` | Yes | Sender name |
| `email` | `varchar(255)` | Yes | Sender email |
| `subject` | `varchar(255)` | No | Optional subject |
| `message` | `text` | Yes | Inquiry message |
| `project_type` | `varchar(100)` | No | Optional project type |
| `status` | `varchar(50)` | Yes | Default: `unread` |
| `ip_address` | `varchar(45)` | No | Optional anti-spam tracking |
| `user_agent` | `text` | No | Optional anti-spam tracking |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 11.3 Recommended Status Values

| Value | Meaning |
|---|---|
| `unread` | New inquiry |
| `read` | Admin has opened it |
| `replied` | Admin has replied |
| `archived` | No longer active |

## 11.4 Indexes

| Index | Columns | Type |
|---|---|---|
| `contact_inquiries_email_index` | `email` | Normal |
| `contact_inquiries_status_index` | `status` | Normal |
| `contact_inquiries_created_at_index` | `created_at` | Normal |

## 11.5 Notes

- Contact form should use validation and spam protection.
- First version can store inquiries only.
- Email notification can be added after the database flow works.

---

# 12. Table: `settings` — Optional Later

## 12.1 Purpose

Stores site-wide editable settings.

This should be postponed until after core project and case study management works.

## 12.2 Columns

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | `bigserial` | Yes | Primary key |
| `key` | `varchar(150)` | Yes | Unique setting key |
| `value` | `text` | No | Setting value |
| `type` | `varchar(50)` | Yes | `text`, `json`, `boolean`, `number` |
| `group` | `varchar(100)` | No | Example: profile, seo, social |
| `created_at` | `timestamp` | Yes | Laravel timestamp |
| `updated_at` | `timestamp` | Yes | Laravel timestamp |

## 12.3 Possible Future Settings

| Key | Purpose |
|---|---|
| `site_name` | Portfolio/site name |
| `hero_title` | Homepage hero title |
| `hero_subtitle` | Homepage hero subtitle |
| `contact_email` | Public contact email |
| `github_url` | GitHub profile link |
| `linkedin_url` | LinkedIn profile link |
| `cv_url` | Downloadable CV link |
| `seo_default_title` | Default SEO title |
| `seo_default_description` | Default SEO description |

## 12.4 Recommendation

Do not implement settings in Phase 1.

Use static config first, then add this table when the admin panel becomes more mature.

---

# 13. Field Validation Rules

## 13.1 Project Validation

| Field | Rule |
|---|---|
| `title` | Required, string, max 255 |
| `slug` | Required, unique, lowercase slug |
| `short_description` | Required, string |
| `long_description` | Nullable, string |
| `category` | Nullable, string, max 100 |
| `status` | Required, in `draft,published` |
| `thumbnail_url` | Nullable, valid URL |
| `video_url` | Nullable, valid URL |
| `live_url` | Nullable, valid URL |
| `github_url` | Nullable, valid URL |
| `case_study_url` | Nullable, valid URL |
| `is_featured` | Boolean |
| `sort_order` | Integer |
| `started_at` | Nullable, date |
| `completed_at` | Nullable, date, after or equal `started_at` |

---

## 13.2 Project Media Validation

| Field | Rule |
|---|---|
| `project_id` | Required, exists in projects |
| `type` | Required, in `image,video` |
| `url` | Required, valid URL |
| `alt_text` | Nullable, string, max 255 |
| `caption` | Nullable, string, max 255 |
| `sort_order` | Integer |

---

## 13.3 Technology Validation

| Field | Rule |
|---|---|
| `name` | Required, string, max 100 |
| `slug` | Required, unique, lowercase slug |
| `category` | Nullable, string, max 100 |
| `icon` | Nullable, string, max 255 |
| `sort_order` | Integer |

---

## 13.4 Case Study Validation

| Field | Rule |
|---|---|
| `project_id` | Nullable, exists in projects |
| `title` | Required, string, max 255 |
| `slug` | Required, unique, lowercase slug |
| `summary` | Required, string |
| `problem` | Nullable, string |
| `solution` | Nullable, string |
| `results` | Nullable, string |
| `content` | Required, string |
| `cover_image_url` | Nullable, valid URL |
| `status` | Required, in `draft,published` |
| `seo_title` | Nullable, string, max 255 |
| `seo_description` | Nullable, string |
| `published_at` | Nullable, date |

---

## 13.5 Contact Inquiry Validation

| Field | Rule |
|---|---|
| `name` | Required, string, max 255 |
| `email` | Required, valid email, max 255 |
| `subject` | Nullable, string, max 255 |
| `message` | Required, string, minimum 10 characters |
| `project_type` | Nullable, string, max 100 |

---

# 14. Seeder Plan

Initial seeders should create useful demo data for development.

## 14.1 Admin Seeder

Creates one admin user from `.env`.

Seeder should read:

```env
ADMIN_NAME=
ADMIN_EMAIL=
ADMIN_PASSWORD=
```

Rules:

- If admin email already exists, do not duplicate.
- Password must be hashed.
- Never commit real production credentials.

---

## 14.2 Technology Seeder

Recommended initial technologies:

| Name | Category |
|---|---|
| Laravel | backend |
| PHP | backend |
| Next.js | frontend |
| React | frontend |
| TypeScript | frontend |
| Tailwind CSS | frontend |
| Framer Motion | frontend |
| PostgreSQL | database |
| MySQL | database |
| Docker | devops |
| GitHub | devops |
| AWS | devops |
| Playwright | testing |
| PHPUnit | testing |
| REST API | api |
| Laravel Sanctum | api |
| Pusher | realtime |
| WebSockets | realtime |
| ChatGPT | ai |
| Codex | ai |

---

## 14.3 Project Seeder

Create 3–5 sample projects for local development.

At least one seeded project should have:

- No thumbnail image
- No live link
- No GitHub link
- No video URL

This is important for testing fallback UI.

---

## 14.4 Case Study Seeder

Create 1–2 sample case studies.

At least one case study should be linked to a project.

Another can be independent.

---

# 15. API Query Requirements Based on Schema

## 15.1 Public Projects Query

Public project listing must only return:

```text
status = published
```

Recommended order:

```text
sort_order ASC
created_at DESC
```

---

## 15.2 Featured Projects Query

Featured projects must only return:

```text
status = published
is_featured = true
```

Recommended order:

```text
sort_order ASC
created_at DESC
```

---

## 15.3 Public Case Studies Query

Public case study listing must only return:

```text
status = published
```

Recommended order:

```text
published_at DESC
created_at DESC
```

---

## 15.4 Admin Queries

Admin queries can return both:

```text
draft
published
```

Admin should be able to filter by:

- status
- category
- featured
- technology
- search keyword

---

# 16. Migration Creation Order

Laravel migrations should be created in this order:

1. `users`
2. `projects`
3. `project_media`
4. `technologies`
5. `project_technology`
6. `case_studies`
7. `contact_inquiries`
8. `settings` later only if needed

Important:

Create parent tables before child tables.

---

# 17. Model List

Laravel models to create:

| Model | Table |
|---|---|
| `User` | `users` |
| `Project` | `projects` |
| `ProjectMedia` | `project_media` |
| `Technology` | `technologies` |
| `CaseStudy` | `case_studies` |
| `ContactInquiry` | `contact_inquiries` |
| `Setting` | `settings`, later only |

---

# 18. Recommended Laravel Model Relationships

## 18.1 Project Model

```php
public function media()
{
    return $this->hasMany(ProjectMedia::class);
}

public function technologies()
{
    return $this->belongsToMany(Technology::class);
}

public function caseStudies()
{
    return $this->hasMany(CaseStudy::class);
}
```

---

## 18.2 ProjectMedia Model

```php
public function project()
{
    return $this->belongsTo(Project::class);
}
```

---

## 18.3 Technology Model

```php
public function projects()
{
    return $this->belongsToMany(Project::class);
}
```

---

## 18.4 CaseStudy Model

```php
public function project()
{
    return $this->belongsTo(Project::class);
}
```

---

# 19. PostgreSQL Notes

## 19.1 Recommended Types

| Use Case | PostgreSQL Type |
|---|---|
| Primary ID | `bigserial` / Laravel `id()` |
| Short text | `varchar` |
| Long content | `text` |
| Boolean flags | `boolean` |
| Date only | `date` |
| Date and time | `timestamp` |
| JSON content later | `jsonb` |

## 19.2 JSON Usage

Avoid JSON for core relational data in the first version.

Use relational tables for:

- Technologies
- Project media
- Case studies

JSON can be used later for flexible page sections if needed.

---

# 20. Soft Deletes Decision

## 20.1 Recommended First Version

Do not use soft deletes in the first version except possibly for:

- `projects`
- `case_studies`

## 20.2 Reason

Soft deletes are useful when admin users may accidentally delete important public content.

But they also add complexity.

Recommended approach:

| Table | Soft Deletes? |
|---|---|
| `users` | No |
| `projects` | Optional |
| `project_media` | No |
| `technologies` | No |
| `case_studies` | Optional |
| `contact_inquiries` | Optional later |
| `settings` | No |

---

# 21. Security and Privacy Notes

1. Never store plain-text passwords.
2. Never store API keys directly in public tables.
3. Admin APIs must require authentication.
4. Public APIs must only expose published content.
5. Contact inquiries should not be publicly accessible.
6. Validate all URLs before saving.
7. Sanitize rich text content before rendering.
8. Use rate limiting on contact form submission.
9. Store IP address only if needed for spam prevention.
10. Do not expose admin email or internal IDs unnecessarily in public API responses.

---

# 22. What to Build Now vs Later

## 22.1 Build Now

| Feature | Include Now? |
|---|---|
| Users table | Yes |
| Projects table | Yes |
| Project media table | Yes |
| Technologies table | Yes |
| Project technology pivot | Yes |
| Case studies table | Yes |
| Contact inquiries table | Yes |
| Basic seeders | Yes |
| Settings table | No, later |
| File uploads | No, later |
| Cloudinary/S3 storage | No, later |
| Advanced analytics | No, later |
| Multi-admin roles | No, later |

---

## 22.2 Postpone

Postpone these until the core app is stable:

- Multiple admin roles
- File upload management
- Cloudinary upload widget
- AWS S3 storage
- Full CMS page builder
- Blog module
- Newsletter module
- Analytics dashboard
- Comments
- Client testimonials module

---

# 23. Acceptance Criteria

This database design is ready when:

- All required tables are clearly defined.
- Optional media and links are supported.
- Projects can exist without images or external links.
- Case studies can be linked or independent.
- Technologies can be reused across projects.
- Contact inquiries can be stored.
- Admin content can be separated from public content using `status`.
- Public API can safely show only published records.
- Schema supports the planned frontend fallback behavior.
- Migration order is clear.
- Validation rules are defined.
- Seeder expectations are documented.

---

# 24. Next Recommended Document

After this document, create:

```text
docs/05-api-specification.md
```

That document should define:

- Public API endpoints
- Admin API endpoints
- Request payloads
- Response shapes
- Validation errors
- Authentication rules
- API security expectations
- Frontend integration rules
