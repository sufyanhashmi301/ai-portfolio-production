# docs/05-api-specification.md

# API Specification — Modern AI-Inspired Developer Portfolio

## 1. Purpose

This document defines the Laravel API contract for the portfolio application.

It should guide backend implementation, frontend integration, admin panel development, and testing.

The API will support:

- Public project listing
- Public project detail pages
- Featured projects
- Public case study listing
- Public case study detail pages
- Contact form submission
- Admin authentication
- Admin dashboard statistics
- Admin project management
- Admin project media management
- Admin technology management
- Admin case study management
- Admin inquiry management

---

## 2. API Design Principles

1. Use Laravel for the backend API.
2. Use PostgreSQL for persistent data.
3. Return JSON responses only.
4. Public APIs must only expose published content.
5. Admin APIs must require authentication.
6. Do not expose draft content publicly.
7. Do not expose passwords, tokens, or sensitive admin data.
8. Validate every create/update request with Laravel Form Requests.
9. Use API Resources for consistent response shapes.
10. Use pagination for list endpoints.
11. Use slugs for public detail pages.
12. Use IDs for admin edit/delete operations.
13. Allow project media and links to be optional.
14. Add rate limiting to login and contact form endpoints.
15. Use environment variables for frontend URL, backend URL, mail config, and secrets.

---

## 3. Base URLs

Local backend API:

```text
http://localhost:8000/api
```

Local frontend:

```text
http://localhost:3000
```

Frontend environment variable:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

Backend environment variable:

```env
FRONTEND_URL=http://localhost:3000
```

---

## 4. API Versioning

Use this for the first version:

```text
/api
```

Do not add `/api/v1` yet unless the application grows and versioning becomes necessary.

---

## 5. Authentication

## 5.1 Recommended Auth Method

Use Laravel Sanctum for admin authentication.

Admin authentication should support:

- Login
- Logout
- Current admin user
- Protected admin routes

## 5.2 Public Routes

These routes do not require authentication:

```text
GET /api/projects
GET /api/projects/featured
GET /api/projects/{slug}
GET /api/case-studies
GET /api/case-studies/{slug}
POST /api/contact
```

## 5.3 Protected Routes

All routes under this prefix require authentication:

```text
/api/admin/*
```

Exception:

```text
POST /api/admin/login
```

---

## 6. Standard Response Format

## 6.1 Single Resource Response

```json
{
  "data": {
    "id": 1,
    "title": "Example Project"
  }
}
```

## 6.2 Collection Response

```json
{
  "data": [],
  "meta": {
    "current_page": 1,
    "per_page": 12,
    "total": 30,
    "last_page": 3
  }
}
```

## 6.3 Action Response

```json
{
  "message": "Project created successfully.",
  "data": {}
}
```

## 6.4 Validation Error Response

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."]
  }
}
```

## 6.5 Unauthorized Response

```json
{
  "message": "Unauthenticated."
}
```

## 6.6 Not Found Response

```json
{
  "message": "Resource not found."
}
```

---

## 7. HTTP Status Codes

| Code | Meaning | Usage |
|---|---|---|
| `200` | OK | Successful read/update/status action |
| `201` | Created | Resource created |
| `204` | No Content | Successful delete, optional |
| `401` | Unauthorized | User is not authenticated |
| `403` | Forbidden | User is authenticated but not allowed |
| `404` | Not Found | Resource missing or hidden |
| `422` | Validation Error | Request data failed validation |
| `429` | Too Many Requests | Rate limit exceeded |
| `500` | Server Error | Unexpected backend issue |

---

# 8. Public Project APIs

## 8.1 List Published Projects

```http
GET /api/projects
```

## Purpose

Returns published projects for the public projects page.

## Authentication

Not required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `page` | integer | No | Page number |
| `per_page` | integer | No | Default `12` |
| `category` | string | No | Filter by project category |
| `technology` | string | No | Filter by technology slug |
| `search` | string | No | Search title and description |

## Backend Rules

- Return only projects where `status = published`.
- Sort by `sort_order ASC`, then `created_at DESC`.
- Include technologies.
- Do not expose admin-only fields.

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "School Management ERP",
      "slug": "school-management-erp",
      "short_description": "A full-stack school ERP with admissions, fees, attendance, academics, and dashboards.",
      "category": "ERP / CRM",
      "thumbnail_url": null,
      "video_url": null,
      "live_url": "https://example.com",
      "github_url": null,
      "case_study_url": "/case-studies/school-management-erp",
      "is_featured": true,
      "technologies": [
        {
          "id": 1,
          "name": "Laravel",
          "slug": "laravel",
          "category": "backend"
        }
      ]
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 12,
    "total": 1,
    "last_page": 1
  }
}
```

## Frontend Rules

| API Field | Frontend Behavior |
|---|---|
| `thumbnail_url = null` | Show professional gradient placeholder |
| `video_url = null` | Hide video button |
| `live_url = null` | Hide live demo button |
| `github_url = null` | Hide GitHub button |
| `case_study_url = null` | Hide case study button |

---

## 8.2 List Featured Projects

```http
GET /api/projects/featured
```

## Purpose

Returns projects for the homepage featured projects section.

## Authentication

Not required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `limit` | integer | No | Default `3`, maximum `6` |

## Backend Rules

- Return only `status = published`.
- Return only `is_featured = true`.
- Sort by `sort_order ASC`, then `created_at DESC`.

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "FinTech CRM Dashboard",
      "slug": "fintech-crm-dashboard",
      "short_description": "A Laravel-powered CRM dashboard with API integrations and role-based access.",
      "category": "FinTech",
      "thumbnail_url": null,
      "live_url": null,
      "github_url": null,
      "case_study_url": "/case-studies/fintech-crm-dashboard",
      "technologies": [
        {
          "id": 1,
          "name": "Laravel",
          "slug": "laravel"
        }
      ]
    }
  ]
}
```

---

## 8.3 Get Project Detail

```http
GET /api/projects/{slug}
```

## Purpose

Returns a single published project by slug.

## Authentication

Not required.

## Backend Rules

- Return only if `status = published`.
- Return `404` if project is draft or not found.
- Include technologies.
- Include media.
- Include related case studies if available.

## Example Response

```json
{
  "data": {
    "id": 1,
    "title": "School Management ERP",
    "slug": "school-management-erp",
    "short_description": "A complete school ERP system.",
    "long_description": "A production-level ERP system for managing admissions, fees, students, teachers, attendance, academics, notifications, and dashboards.",
    "category": "ERP / CRM",
    "thumbnail_url": null,
    "video_url": null,
    "live_url": "https://example.com",
    "github_url": null,
    "case_study_url": "/case-studies/school-management-erp",
    "is_featured": true,
    "started_at": "2025-01-01",
    "completed_at": null,
    "technologies": [
      {
        "id": 1,
        "name": "Laravel",
        "slug": "laravel",
        "category": "backend"
      }
    ],
    "media": [
      {
        "id": 1,
        "type": "image",
        "url": "https://example.com/screenshot.png",
        "alt_text": "ERP dashboard screenshot",
        "caption": "Admin dashboard",
        "sort_order": 1
      }
    ],
    "case_studies": [
      {
        "id": 1,
        "title": "Building a Scalable School ERP",
        "slug": "building-scalable-school-erp",
        "summary": "How the ERP was designed for multi-module school operations."
      }
    ]
  }
}
```

---

# 9. Public Case Study APIs

## 9.1 List Published Case Studies

```http
GET /api/case-studies
```

## Purpose

Returns published case studies for the public case studies page.

## Authentication

Not required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `page` | integer | No | Page number |
| `per_page` | integer | No | Default `9` |
| `search` | string | No | Search title, summary, problem, and solution |

## Backend Rules

- Return only `status = published`.
- Sort by `published_at DESC`, then `created_at DESC`.
- Include related project summary if available.

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "Building a Scalable School ERP",
      "slug": "building-scalable-school-erp",
      "summary": "How a modular ERP system was structured for school operations.",
      "cover_image_url": null,
      "published_at": "2026-05-01T10:00:00Z",
      "project": {
        "id": 1,
        "title": "School Management ERP",
        "slug": "school-management-erp"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 9,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 9.2 Get Case Study Detail

```http
GET /api/case-studies/{slug}
```

## Purpose

Returns a single published case study by slug.

## Authentication

Not required.

## Backend Rules

- Return only if `status = published`.
- Return `404` if draft or not found.
- Include related project if available.
- Use SEO fields when present.

## Example Response

```json
{
  "data": {
    "id": 1,
    "title": "Building a Scalable School ERP",
    "slug": "building-scalable-school-erp",
    "summary": "How a modular ERP was structured for school operations.",
    "problem": "The client needed one system to manage admissions, fees, students, teachers, attendance, and reporting.",
    "solution": "The solution used a modular Laravel API with a modern frontend and role-based access.",
    "results": "Reduced manual admin work and improved visibility across academic and finance modules.",
    "content": "Full long-form case study content goes here.",
    "cover_image_url": null,
    "seo_title": "School ERP Case Study",
    "seo_description": "A technical case study on building a scalable school ERP.",
    "published_at": "2026-05-01T10:00:00Z",
    "project": {
      "id": 1,
      "title": "School Management ERP",
      "slug": "school-management-erp",
      "category": "ERP / CRM",
      "thumbnail_url": null
    }
  }
}
```

---

# 10. Contact API

## 10.1 Submit Contact Inquiry

```http
POST /api/contact
```

## Purpose

Stores contact form submissions.

## Authentication

Not required.

## Rate Limit

Recommended:

```text
5 requests per minute per IP
```

## Request Body

```json
{
  "name": "Client Name",
  "email": "client@example.com",
  "subject": "Project inquiry",
  "message": "I want to discuss a Laravel and Next.js project.",
  "project_type": "Laravel / API Development"
}
```

## Validation Rules

| Field | Rule |
|---|---|
| `name` | Required, string, max 255 |
| `email` | Required, valid email, max 255 |
| `subject` | Nullable, string, max 255 |
| `message` | Required, string, min 10 |
| `project_type` | Nullable, string, max 100 |

## Success Response

```json
{
  "message": "Your message has been submitted successfully."
}
```

## Backend Behavior

1. Validate request.
2. Store inquiry in `contact_inquiries`.
3. Save `ip_address` if enabled.
4. Save `user_agent` if enabled.
5. Optionally send email notification later.
6. Return success message.

---

# 11. Admin Authentication APIs

## 11.1 Admin Login

```http
POST /api/admin/login
```

## Request Body

```json
{
  "email": "admin@example.com",
  "password": "secure-password"
}
```

## Success Response

```json
{
  "message": "Logged in successfully.",
  "data": {
    "user": {
      "id": 1,
      "name": "Sufyan",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "plain-text-token-returned-once"
  }
}
```

## Failure Response

```json
{
  "message": "Invalid login credentials."
}
```

Recommended status:

```text
401 Unauthorized
```

---

## 11.2 Admin Logout

```http
POST /api/admin/logout
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Logged out successfully."
}
```

---

## 11.3 Current Admin User

```http
GET /api/admin/me
```

## Authentication

Required.

## Success Response

```json
{
  "data": {
    "id": 1,
    "name": "Sufyan",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

---

# 12. Admin Dashboard API

## 12.1 Dashboard Statistics

```http
GET /api/admin/dashboard
```

## Authentication

Required.

## Example Response

```json
{
  "data": {
    "total_projects": 12,
    "published_projects": 8,
    "draft_projects": 4,
    "featured_projects": 3,
    "total_case_studies": 5,
    "published_case_studies": 3,
    "draft_case_studies": 2,
    "total_inquiries": 20,
    "unread_inquiries": 4,
    "recent_inquiries": [
      {
        "id": 1,
        "name": "Client Name",
        "email": "client@example.com",
        "subject": "Laravel project",
        "status": "unread",
        "created_at": "2026-05-10T10:00:00Z"
      }
    ]
  }
}
```

---

# 13. Admin Project APIs

## 13.1 List All Projects

```http
GET /api/admin/projects
```

## Authentication

Required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `page` | integer | No | Page number |
| `per_page` | integer | No | Default `15` |
| `status` | string | No | `draft` or `published` |
| `category` | string | No | Filter by category |
| `technology` | string | No | Filter by technology slug |
| `featured` | boolean | No | Filter featured projects |
| `search` | string | No | Search title and description |

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "School Management ERP",
      "slug": "school-management-erp",
      "short_description": "A complete school ERP.",
      "category": "ERP / CRM",
      "status": "published",
      "thumbnail_url": null,
      "is_featured": true,
      "sort_order": 1,
      "created_at": "2026-05-01T10:00:00Z",
      "updated_at": "2026-05-02T10:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 13.2 Create Project

```http
POST /api/admin/projects
```

## Authentication

Required.

## Request Body

```json
{
  "title": "School Management ERP",
  "slug": "school-management-erp",
  "short_description": "A complete school ERP system.",
  "long_description": "Detailed project explanation.",
  "category": "ERP / CRM",
  "status": "draft",
  "thumbnail_url": null,
  "video_url": null,
  "live_url": null,
  "github_url": null,
  "case_study_url": null,
  "is_featured": false,
  "sort_order": 1,
  "started_at": "2025-01-01",
  "completed_at": null,
  "technology_ids": [1, 2, 3]
}
```

## Validation Rules

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
| `technology_ids` | Nullable, array |
| `technology_ids.*` | Exists in `technologies.id` |

## Success Response

```json
{
  "message": "Project created successfully.",
  "data": {
    "id": 1,
    "title": "School Management ERP",
    "slug": "school-management-erp",
    "status": "draft"
  }
}
```

---

## 13.3 Get Admin Project Detail

```http
GET /api/admin/projects/{id}
```

## Authentication

Required.

## Example Response

```json
{
  "data": {
    "id": 1,
    "title": "School Management ERP",
    "slug": "school-management-erp",
    "short_description": "A complete school ERP system.",
    "long_description": "Detailed project explanation.",
    "category": "ERP / CRM",
    "status": "draft",
    "thumbnail_url": null,
    "video_url": null,
    "live_url": null,
    "github_url": null,
    "case_study_url": null,
    "is_featured": false,
    "sort_order": 1,
    "started_at": "2025-01-01",
    "completed_at": null,
    "technologies": [],
    "media": [],
    "created_at": "2026-05-01T10:00:00Z",
    "updated_at": "2026-05-01T10:00:00Z"
  }
}
```

---

## 13.4 Update Project

```http
PUT /api/admin/projects/{id}
PATCH /api/admin/projects/{id}
```

## Authentication

Required.

## Request Body

Same fields as create project.

## Important Rule

When updating slug, the slug must be unique except for the current project.

## Success Response

```json
{
  "message": "Project updated successfully.",
  "data": {
    "id": 1,
    "title": "School Management ERP",
    "slug": "school-management-erp",
    "status": "published"
  }
}
```

---

## 13.5 Delete Project

```http
DELETE /api/admin/projects/{id}
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Project deleted successfully."
}
```

---

## 13.6 Publish Project

```http
PATCH /api/admin/projects/{id}/publish
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Project published successfully.",
  "data": {
    "id": 1,
    "status": "published"
  }
}
```

---

## 13.7 Unpublish Project

```http
PATCH /api/admin/projects/{id}/unpublish
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Project unpublished successfully.",
  "data": {
    "id": 1,
    "status": "draft"
  }
}
```

---

## 13.8 Feature Project

```http
PATCH /api/admin/projects/{id}/feature
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Project marked as featured.",
  "data": {
    "id": 1,
    "is_featured": true
  }
}
```

---

## 13.9 Unfeature Project

```http
PATCH /api/admin/projects/{id}/unfeature
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Project removed from featured.",
  "data": {
    "id": 1,
    "is_featured": false
  }
}
```

---

# 14. Admin Project Media APIs

## 14.1 Add Project Media

```http
POST /api/admin/projects/{projectId}/media
```

## Authentication

Required.

## Request Body

```json
{
  "type": "image",
  "url": "https://example.com/screenshot.png",
  "alt_text": "Project dashboard screenshot",
  "caption": "Admin dashboard screen",
  "sort_order": 1
}
```

## Validation Rules

| Field | Rule |
|---|---|
| `type` | Required, in `image,video` |
| `url` | Required, valid URL |
| `alt_text` | Nullable, string, max 255 |
| `caption` | Nullable, string, max 255 |
| `sort_order` | Integer |

## Success Response

```json
{
  "message": "Project media added successfully.",
  "data": {
    "id": 1,
    "type": "image",
    "url": "https://example.com/screenshot.png"
  }
}
```

---

## 14.2 Update Project Media

```http
PATCH /api/admin/project-media/{id}
```

## Authentication

Required.

## Request Body

```json
{
  "type": "image",
  "url": "https://example.com/new-screenshot.png",
  "alt_text": "Updated screenshot",
  "caption": "Updated caption",
  "sort_order": 2
}
```

## Success Response

```json
{
  "message": "Project media updated successfully.",
  "data": {
    "id": 1,
    "type": "image",
    "url": "https://example.com/new-screenshot.png"
  }
}
```

---

## 14.3 Delete Project Media

```http
DELETE /api/admin/project-media/{id}
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Project media deleted successfully."
}
```

---

# 15. Admin Technology APIs

## 15.1 List Technologies

```http
GET /api/admin/technologies
```

## Authentication

Required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `category` | string | No | Filter by category |
| `search` | string | No | Search technology name |

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "name": "Laravel",
      "slug": "laravel",
      "category": "backend",
      "icon": null,
      "sort_order": 1
    }
  ]
}
```

---

## 15.2 Create Technology

```http
POST /api/admin/technologies
```

## Authentication

Required.

## Request Body

```json
{
  "name": "Laravel",
  "slug": "laravel",
  "category": "backend",
  "icon": null,
  "sort_order": 1
}
```

## Validation Rules

| Field | Rule |
|---|---|
| `name` | Required, string, max 100 |
| `slug` | Required, unique, lowercase slug |
| `category` | Nullable, string, max 100 |
| `icon` | Nullable, string, max 255 |
| `sort_order` | Integer |

## Success Response

```json
{
  "message": "Technology created successfully.",
  "data": {
    "id": 1,
    "name": "Laravel",
    "slug": "laravel"
  }
}
```

---

## 15.3 Update Technology

```http
PATCH /api/admin/technologies/{id}
```

## Authentication

Required.

## Request Body

Same fields as create technology.

## Success Response

```json
{
  "message": "Technology updated successfully.",
  "data": {
    "id": 1,
    "name": "Laravel",
    "slug": "laravel"
  }
}
```

---

## 15.4 Delete Technology

```http
DELETE /api/admin/technologies/{id}
```

## Authentication

Required.

## Recommended Behavior

Prevent deletion if technology is attached to existing projects.

## Error Example

```json
{
  "message": "This technology is attached to existing projects and cannot be deleted."
}
```

---

# 16. Admin Case Study APIs

## 16.1 List All Case Studies

```http
GET /api/admin/case-studies
```

## Authentication

Required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `page` | integer | No | Page number |
| `per_page` | integer | No | Default `15` |
| `status` | string | No | `draft` or `published` |
| `project_id` | integer | No | Filter by project |
| `search` | string | No | Search title and summary |

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "Building a Scalable School ERP",
      "slug": "building-scalable-school-erp",
      "summary": "How a modular ERP was designed.",
      "status": "published",
      "cover_image_url": null,
      "published_at": "2026-05-01T10:00:00Z",
      "project": {
        "id": 1,
        "title": "School Management ERP",
        "slug": "school-management-erp"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 16.2 Create Case Study

```http
POST /api/admin/case-studies
```

## Authentication

Required.

## Request Body

```json
{
  "project_id": 1,
  "title": "Building a Scalable School ERP",
  "slug": "building-scalable-school-erp",
  "summary": "How a modular ERP was designed.",
  "problem": "The client needed one system for multiple school operations.",
  "solution": "A Laravel API and modern frontend were used.",
  "results": "Improved admin control and reduced manual work.",
  "content": "Full case study content.",
  "cover_image_url": null,
  "status": "draft",
  "seo_title": "School ERP Case Study",
  "seo_description": "A technical case study about a school ERP.",
  "published_at": null
}
```

## Validation Rules

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

## Success Response

```json
{
  "message": "Case study created successfully.",
  "data": {
    "id": 1,
    "title": "Building a Scalable School ERP",
    "slug": "building-scalable-school-erp",
    "status": "draft"
  }
}
```

---

## 16.3 Get Admin Case Study Detail

```http
GET /api/admin/case-studies/{id}
```

## Authentication

Required.

## Example Response

```json
{
  "data": {
    "id": 1,
    "project_id": 1,
    "title": "Building a Scalable School ERP",
    "slug": "building-scalable-school-erp",
    "summary": "How a modular ERP was designed.",
    "problem": "Problem text.",
    "solution": "Solution text.",
    "results": "Results text.",
    "content": "Full content.",
    "cover_image_url": null,
    "status": "draft",
    "seo_title": null,
    "seo_description": null,
    "published_at": null,
    "created_at": "2026-05-01T10:00:00Z",
    "updated_at": "2026-05-01T10:00:00Z"
  }
}
```

---

## 16.4 Update Case Study

```http
PUT /api/admin/case-studies/{id}
PATCH /api/admin/case-studies/{id}
```

## Authentication

Required.

## Request Body

Same fields as create case study.

## Important Rule

When updating slug, the slug must be unique except for the current case study.

## Success Response

```json
{
  "message": "Case study updated successfully.",
  "data": {
    "id": 1,
    "title": "Building a Scalable School ERP",
    "slug": "building-scalable-school-erp",
    "status": "published"
  }
}
```

---

## 16.5 Delete Case Study

```http
DELETE /api/admin/case-studies/{id}
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Case study deleted successfully."
}
```

---

## 16.6 Publish Case Study

```http
PATCH /api/admin/case-studies/{id}/publish
```

## Authentication

Required.

## Backend Rule

Set `status = published`.

If `published_at` is empty, set it to current timestamp.

## Success Response

```json
{
  "message": "Case study published successfully.",
  "data": {
    "id": 1,
    "status": "published",
    "published_at": "2026-05-11T10:00:00Z"
  }
}
```

---

## 16.7 Unpublish Case Study

```http
PATCH /api/admin/case-studies/{id}/unpublish
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Case study unpublished successfully.",
  "data": {
    "id": 1,
    "status": "draft"
  }
}
```

---

# 17. Admin Contact Inquiry APIs

## 17.1 List Inquiries

```http
GET /api/admin/inquiries
```

## Authentication

Required.

## Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `page` | integer | No | Page number |
| `per_page` | integer | No | Default `15` |
| `status` | string | No | `unread`, `read`, `replied`, `archived` |
| `search` | string | No | Search name, email, subject, message |

## Example Response

```json
{
  "data": [
    {
      "id": 1,
      "name": "Client Name",
      "email": "client@example.com",
      "subject": "Laravel project",
      "project_type": "Laravel / API Development",
      "status": "unread",
      "created_at": "2026-05-10T10:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 17.2 Get Inquiry Detail

```http
GET /api/admin/inquiries/{id}
```

## Authentication

Required.

## Example Response

```json
{
  "data": {
    "id": 1,
    "name": "Client Name",
    "email": "client@example.com",
    "subject": "Laravel project",
    "message": "I want to discuss a Laravel and Next.js project.",
    "project_type": "Laravel / API Development",
    "status": "unread",
    "ip_address": "127.0.0.1",
    "user_agent": "Browser user agent",
    "created_at": "2026-05-10T10:00:00Z"
  }
}
```

---

## 17.3 Update Inquiry Status

```http
PATCH /api/admin/inquiries/{id}/status
```

## Authentication

Required.

## Request Body

```json
{
  "status": "replied"
}
```

## Validation Rules

| Field | Rule |
|---|---|
| `status` | Required, in `unread,read,replied,archived` |

## Success Response

```json
{
  "message": "Inquiry status updated successfully.",
  "data": {
    "id": 1,
    "status": "replied"
  }
}
```

---

## 17.4 Delete Inquiry

```http
DELETE /api/admin/inquiries/{id}
```

## Authentication

Required.

## Success Response

```json
{
  "message": "Inquiry deleted successfully."
}
```

---

# 18. Laravel Route Structure

Recommended route organization:

```php
Route::prefix('projects')->group(function () {
    Route::get('/', [PublicProjectController::class, 'index']);
    Route::get('/featured', [PublicProjectController::class, 'featured']);
    Route::get('/{slug}', [PublicProjectController::class, 'show']);
});

Route::prefix('case-studies')->group(function () {
    Route::get('/', [PublicCaseStudyController::class, 'index']);
    Route::get('/{slug}', [PublicCaseStudyController::class, 'show']);
});

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact');

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        Route::apiResource('/projects', AdminProjectController::class);
        Route::patch('/projects/{project}/publish', [AdminProjectStatusController::class, 'publish']);
        Route::patch('/projects/{project}/unpublish', [AdminProjectStatusController::class, 'unpublish']);
        Route::patch('/projects/{project}/feature', [AdminProjectStatusController::class, 'feature']);
        Route::patch('/projects/{project}/unfeature', [AdminProjectStatusController::class, 'unfeature']);

        Route::post('/projects/{project}/media', [AdminProjectMediaController::class, 'store']);
        Route::patch('/project-media/{media}', [AdminProjectMediaController::class, 'update']);
        Route::delete('/project-media/{media}', [AdminProjectMediaController::class, 'destroy']);

        Route::apiResource('/technologies', AdminTechnologyController::class);

        Route::apiResource('/case-studies', AdminCaseStudyController::class);
        Route::patch('/case-studies/{caseStudy}/publish', [AdminCaseStudyStatusController::class, 'publish']);
        Route::patch('/case-studies/{caseStudy}/unpublish', [AdminCaseStudyStatusController::class, 'unpublish']);

        Route::get('/inquiries', [AdminInquiryController::class, 'index']);
        Route::get('/inquiries/{inquiry}', [AdminInquiryController::class, 'show']);
        Route::patch('/inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus']);
        Route::delete('/inquiries/{inquiry}', [AdminInquiryController::class, 'destroy']);
    });
});
```

---

# 19. Suggested Controller List

| Controller | Purpose |
|---|---|
| `PublicProjectController` | Public project listing and detail |
| `PublicCaseStudyController` | Public case study listing and detail |
| `ContactController` | Contact form submission |
| `AdminAuthController` | Admin login, logout, current user |
| `AdminDashboardController` | Dashboard statistics |
| `AdminProjectController` | Admin project CRUD |
| `AdminProjectStatusController` | Publish, unpublish, feature, unfeature |
| `AdminProjectMediaController` | Project media CRUD |
| `AdminTechnologyController` | Technology CRUD |
| `AdminCaseStudyController` | Case study CRUD |
| `AdminCaseStudyStatusController` | Publish and unpublish case studies |
| `AdminInquiryController` | Inquiry management |

---

# 20. Suggested Form Request Classes

| Form Request | Purpose |
|---|---|
| `AdminLoginRequest` | Admin login validation |
| `StoreContactInquiryRequest` | Contact form validation |
| `StoreProjectRequest` | Create project validation |
| `UpdateProjectRequest` | Update project validation |
| `StoreProjectMediaRequest` | Add project media validation |
| `UpdateProjectMediaRequest` | Update project media validation |
| `StoreTechnologyRequest` | Create technology validation |
| `UpdateTechnologyRequest` | Update technology validation |
| `StoreCaseStudyRequest` | Create case study validation |
| `UpdateCaseStudyRequest` | Update case study validation |
| `UpdateInquiryStatusRequest` | Inquiry status validation |

---

# 21. Suggested API Resource Classes

| Resource | Purpose |
|---|---|
| `ProjectCardResource` | Public project cards |
| `ProjectDetailResource` | Public project detail |
| `AdminProjectResource` | Admin project listing/detail |
| `ProjectMediaResource` | Project media |
| `TechnologyResource` | Technologies |
| `CaseStudyCardResource` | Public case study cards |
| `CaseStudyDetailResource` | Public case study detail |
| `AdminCaseStudyResource` | Admin case study listing/detail |
| `ContactInquiryResource` | Admin inquiry listing/detail |
| `AdminUserResource` | Authenticated admin user |

---

# 22. Frontend Integration Rules

## 22.1 Missing Project Images

If `thumbnail_url` is null, the frontend must show:

- Professional gradient placeholder
- Project category
- Subtle AI-inspired glow
- Clean card layout

Do not show broken images.

## 22.2 Missing Project Links

Render buttons only when values exist:

| URL Field | Button |
|---|---|
| `live_url` | Live Demo |
| `github_url` | GitHub |
| `video_url` | Watch Video |
| `case_study_url` | Case Study |

## 22.3 Draft Content

Draft projects and draft case studies must never appear publicly.

Protection must happen at backend level, not only frontend level.

## 22.4 Loading, Empty, and Error States

Each API-powered frontend page should have:

- Loading state
- Empty state
- Error state
- Not found state

---

# 23. SEO Integration Rules

Project and case study detail pages should generate metadata from API data.

| Metadata | Primary | Fallback |
|---|---|---|
| Page title | `seo_title` | `title` |
| Description | `seo_description` | `summary` or `short_description` |
| Image | `cover_image_url` / `thumbnail_url` | Default Open Graph image |

---

# 24. Security Requirements

## 24.1 Public API Security

Public APIs should:

- Return only published content.
- Hide draft content.
- Hide admin-only fields.
- Validate contact form data.
- Rate-limit contact submissions.
- Avoid exposing stack traces.
- Sanitize content before frontend rendering.

## 24.2 Admin API Security

Admin APIs should:

- Require authentication.
- Use Laravel Sanctum or secure session authentication.
- Validate all request data.
- Never expose password hashes.
- Never accept unvalidated status values.
- Restrict access by admin role.
- Use environment variables for all secrets.

## 24.3 CORS

Allow requests only from configured frontend origins.

Local allowed origin:

```text
http://localhost:3000
```

Production frontend domain must be configured through environment variables.

---

# 25. Rate Limiting

Recommended limits:

| Endpoint Group | Limit |
|---|---|
| Public project APIs | Standard Laravel throttle |
| Public case study APIs | Standard Laravel throttle |
| Contact form | 5 requests per minute per IP |
| Admin login | 5 attempts per minute per email/IP |
| Authenticated admin APIs | Standard authenticated throttle |

---

# 26. Backend Testing Requirements

## 26.1 Public API Tests

| Test | Expected Result |
|---|---|
| Published projects endpoint returns only published projects | Draft projects hidden |
| Featured projects endpoint returns only published featured projects | Draft featured projects hidden |
| Project detail returns published project by slug | 200 response |
| Project detail does not return draft project | 404 response |
| Case studies endpoint returns only published case studies | Draft case studies hidden |
| Contact form accepts valid data | Inquiry stored |
| Contact form rejects invalid email | 422 response |
| Contact form rejects short message | 422 response |

---

## 26.2 Admin API Tests

| Test | Expected Result |
|---|---|
| Admin can log in with valid credentials | 200 response |
| Admin cannot log in with invalid credentials | 401 response |
| Unauthenticated user cannot access admin projects | 401 response |
| Admin can create project | Project stored |
| Admin can update project | Project updated |
| Admin can publish/unpublish project | Status changes |
| Admin can feature/unfeature project | Featured flag changes |
| Admin can create project media | Media stored |
| Admin can create technology | Technology stored |
| Admin can create case study | Case study stored |
| Admin can publish/unpublish case study | Status changes |
| Admin can update inquiry status | Status changes |

---

# 27. What to Build Now vs Later

## 27.1 Build Now

| API Area | Include Now? |
|---|---|
| Public project listing | Yes |
| Public project detail | Yes |
| Featured projects | Yes |
| Public case studies | Yes |
| Public case study detail | Yes |
| Contact form | Yes |
| Admin login/logout/me | Yes |
| Admin dashboard stats | Yes |
| Project CRUD | Yes |
| Project media CRUD | Yes |
| Technology CRUD | Yes |
| Case study CRUD | Yes |
| Inquiry management | Yes |

## 27.2 Postpone

Postpone these until the core app is stable:

- Blog APIs
- Newsletter APIs
- Testimonials APIs
- File upload APIs
- Cloudinary direct upload APIs
- AWS S3 upload APIs
- Analytics APIs
- Multi-admin roles
- Activity logs
- Public comments
- Advanced CMS page builder

---

# 28. Acceptance Criteria

This API specification is ready when:

- Public endpoints are clearly defined.
- Admin endpoints are clearly defined.
- Authentication rules are clear.
- Request payloads are documented.
- Response shapes are documented.
- Validation rules are documented.
- HTTP status codes are defined.
- Frontend fallback behavior is supported.
- Draft content is protected from public APIs.
- Admin APIs require authentication.
- Contact form has validation and rate limiting.
- Controller, request, and resource suggestions are included.
- Testing expectations are clear.

---

# 29. Next Recommended Document

After this document, create:

```text
docs/06-frontend-architecture.md
```

That document should define:

- Next.js folder structure
- App Router layout
- Component architecture
- API integration layer
- TypeScript types
- Reusable UI components
- Public page structure
- Admin page structure
- Loading, error, and empty states
- Frontend testing expectations
