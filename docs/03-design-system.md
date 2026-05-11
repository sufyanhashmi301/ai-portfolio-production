# Modern AI-Inspired Developer Portfolio — Design System

## Document Purpose

This document defines the visual and interaction design system for the portfolio application.

The goal is to create a consistent, premium, modern, AI-inspired interface before writing UI code. This document should guide the implementation of Tailwind CSS theme tokens, reusable UI components, Framer Motion animations, layout patterns, responsive behavior, and visual quality checks.

This design system supports the project vision defined in `docs/01-project-plan.md` and should be treated as the main reference for all frontend UI decisions.

---

## 1. Design Direction

The portfolio should feel like a professional SaaS-style personal brand platform, not a basic CV website.

The design must be:

- Modern
- Decent
- Premium
- Clean
- Professional
- Subtly AI-inspired
- Mobile responsive
- Fast and readable
- Elegant without looking childish or noisy

The design must avoid:

- Too many animations
- Bright childish colors
- Overloaded gradients
- Excessive particles
- Distracting effects
- Poor contrast
- Cluttered sections
- Random spacing
- Inconsistent card styles

Design principle:

> Effects should support the content, not dominate it.

---

## 2. Visual Personality

The portfolio should communicate:

| Attribute | Meaning |
|---|---|
| Premium | The interface should look polished and intentional |
| Technical | The design should reflect engineering, architecture, and systems thinking |
| Trustworthy | The layout should make clients and employers feel confidence |
| AI-inspired | Subtle futuristic effects without becoming flashy |
| Professional | Suitable for Laravel, API, ERP, CRM, SaaS, FinTech, and full-stack work |
| Clear | Visitors should quickly understand skills, projects, and contact options |

---

## 3. Brand Feel

Recommended brand positioning:

> Clean engineering. Scalable systems. Modern interfaces.

Alternative short phrases for UI use:

- Full-stack systems with premium frontend experiences
- Laravel, APIs, dashboards, and modern web products
- Production-ready engineering with modern UI thinking
- Scalable backend logic with clean frontend execution

Tone of website copy:

- Confident, not arrogant
- Clear, not overly technical
- Professional, not robotic
- Business-friendly, not only developer-focused

---

## 4. Color System

The first version should use a dark premium theme as the default because AI-inspired gradients, glass cards, and glow borders work better on deep backgrounds.

### 4.1 Base Colors

| Token | Purpose | Suggested Value |
|---|---|---|
| `background` | Main page background | `#050816` |
| `surface` | Card and panel background | `#0B1020` |
| `surface-soft` | Softer elevated area | `#111827` |
| `surface-glass` | Glass panel background | `rgba(15, 23, 42, 0.62)` |
| `border` | Standard border | `rgba(148, 163, 184, 0.18)` |
| `border-strong` | Highlight border | `rgba(148, 163, 184, 0.32)` |
| `text-primary` | Main text | `#F8FAFC` |
| `text-secondary` | Supporting text | `#CBD5E1` |
| `text-muted` | Muted text | `#94A3B8` |
| `text-soft` | Very subtle text | `#64748B` |

### 4.2 Accent Colors

Use a controlled blue/cyan/violet palette for the AI-inspired identity.

| Token | Purpose | Suggested Value |
|---|---|---|
| `accent-primary` | Main CTA, active states | `#38BDF8` |
| `accent-secondary` | Secondary glow | `#818CF8` |
| `accent-tertiary` | Gradient depth | `#A855F7` |
| `accent-success` | Success states | `#22C55E` |
| `accent-warning` | Warning states | `#F59E0B` |
| `accent-danger` | Error/delete states | `#EF4444` |

### 4.3 Gradient Rules

Use gradients only where they add polish.

Recommended gradients:

```css
background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 32%),
            radial-gradient(circle at top right, rgba(168, 85, 247, 0.16), transparent 30%),
            #050816;
```

Professional placeholder gradient:

```css
background: linear-gradient(135deg, rgba(56, 189, 248, 0.18), rgba(129, 140, 248, 0.14), rgba(168, 85, 247, 0.16));
```

CTA gradient:

```css
background: linear-gradient(135deg, #38BDF8, #818CF8);
```

Avoid:

- Rainbow gradients
- Harsh neon backgrounds
- Multiple gradients on every card
- High-saturation red/yellow combinations

---

## 5. Typography System

Typography should be modern, readable, and professional.

### 5.1 Font Recommendation

Recommended font stack:

```css
font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
```

Optional premium heading font later:

- `Sora`
- `Plus Jakarta Sans`
- `Manrope`

For first version, use one font family to keep the design clean and easy to implement.

### 5.2 Type Scale

| Element | Mobile | Desktop | Weight |
|---|---:|---:|---:|
| Hero heading | 40px | 64px–72px | 700–800 |
| Page heading | 34px | 56px | 700 |
| Section heading | 28px | 40px | 700 |
| Card title | 18px | 22px | 600 |
| Body text | 16px | 17px | 400 |
| Small text | 14px | 14px | 400–500 |
| Badge text | 12px | 13px | 500 |

### 5.3 Typography Rules

- Use generous line height for readability.
- Keep paragraph width controlled.
- Avoid long text blocks in the hero section.
- Use strong headings and short supporting paragraphs.
- Use muted text for secondary descriptions.
- Never use more than two font families.

Recommended line heights:

| Text Type | Line Height |
|---|---:|
| Headings | `1.05–1.15` |
| Body | `1.6–1.8` |
| Small labels | `1.4` |

---

## 6. Spacing System

Use consistent spacing instead of random margins.

### 6.1 Section Spacing

| Area | Mobile | Desktop |
|---|---:|---:|
| Page top padding | 96px | 128px |
| Section vertical padding | 64px | 96px–120px |
| Card padding | 20px | 24px–32px |
| Grid gap | 20px | 24px–32px |
| Hero content gap | 24px | 32px |

### 6.2 Container Widths

| Container | Width |
|---|---:|
| Default content | `max-w-7xl` |
| Text-focused content | `max-w-3xl` |
| Case study article | `max-w-4xl` |
| Admin content | `max-w-screen-2xl` |

### 6.3 Layout Rule

Every public page should use a shared `Container` component to avoid inconsistent widths.

---

## 7. Border Radius and Shadows

The interface should feel soft and premium.

| Element | Radius |
|---|---:|
| Small badge | `rounded-full` |
| Button | `rounded-xl` or `rounded-2xl` |
| Card | `rounded-2xl` |
| Large hero panel | `rounded-3xl` |
| Modal/dialog | `rounded-2xl` |

Shadow style:

```css
box-shadow: 0 24px 80px rgba(15, 23, 42, 0.36);
```

Glow border style:

```css
box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.12),
            0 20px 60px rgba(56, 189, 248, 0.08);
```

Use shadows subtly. Cards should not look like floating plastic blocks.

---

## 8. Glassmorphism Rules

Glass cards should be used for premium AI-style panels.

Recommended glass card:

```css
background: rgba(15, 23, 42, 0.62);
backdrop-filter: blur(18px);
border: 1px solid rgba(148, 163, 184, 0.18);
```

Use glass effects for:

- Hero profile summary card
- Featured project cards
- Stats cards
- Navbar background
- Admin dashboard summary cards

Do not use glass effects for every small element.

---

## 9. Background Effects

The background should create a subtle AI-inspired feel.

Recommended effects:

1. Dark base background
2. Soft radial gradient glows
3. Very subtle grid pattern
4. Optional noise overlay
5. Optional minimal moving gradient layer

### 9.1 Animated Grid Background

Use a low-opacity grid:

```css
background-image:
  linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
  linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
background-size: 48px 48px;
```

Animation rule:

- Very slow movement only
- Low opacity
- Should not reduce text readability

### 9.2 Noise Overlay

A subtle noise texture can make gradients feel premium.

Rule:

- Keep opacity between `0.03` and `0.06`
- Do not make texture visible on text-heavy sections

---

## 10. Component Design Rules

### 10.1 Button Component

Button variants:

| Variant | Usage |
|---|---|
| Primary | Main CTA: Contact, View Projects |
| Secondary | Alternative CTA: GitHub, Case Study |
| Ghost | Navbar and subtle actions |
| Outline | Admin or low-priority actions |
| Danger | Delete actions in admin |

Primary button style:

- Gradient background
- Strong text contrast
- Soft glow on hover
- Slight upward motion on hover

Button states:

- Default
- Hover
- Focus
- Disabled
- Loading

Button rules:

- Never use disabled buttons without visual indication.
- Use visible focus ring for keyboard accessibility.
- Do not animate buttons aggressively.

---

### 10.2 Card Component

Card variants:

| Variant | Usage |
|---|---|
| Default | Normal content cards |
| Glass | Premium dark glass cards |
| Glow | Featured project cards |
| Flat | Admin tables/forms |
| Interactive | Clickable project cards |

Project cards should include:

- Optional thumbnail or gradient placeholder
- Title
- Short description
- Tech badges
- Optional links
- Featured badge if applicable

Card hover behavior:

- Slight translate up: `-4px`
- Border becomes more visible
- Glow becomes slightly stronger
- No dramatic scaling

---

### 10.3 Badge Component

Badge types:

| Type | Example |
|---|---|
| Technology | Laravel, Next.js, PostgreSQL |
| Category | ERP, FinTech, SaaS, API |
| Status | Featured, Published, Draft |
| Role | Backend, Full-stack, API Integration |

Badge style:

```css
background: rgba(148, 163, 184, 0.10);
border: 1px solid rgba(148, 163, 184, 0.16);
color: #CBD5E1;
```

Badge rules:

- Keep badges small and readable.
- Wrap badges cleanly on mobile.
- Avoid too many badges on a card; show important ones first.

---

### 10.4 Section Heading Component

Every major section should use a consistent heading pattern:

- Eyebrow label
- Main heading
- Short supporting description

Example structure:

```text
Featured Work
Selected projects that show real-world systems, dashboards, APIs, and full-stack delivery.
```

Rules:

- Use left alignment for most sections.
- Center alignment only for hero or CTA sections.
- Avoid long section descriptions.

---

### 10.5 Gradient Placeholder Component

If a project has no image, show a professional placeholder instead of a broken or empty image area.

The placeholder should include:

- Soft gradient background
- Subtle grid or glow
- Project initials or icon
- Optional project category label

Rules:

- Placeholder must look intentional.
- Never show empty white/gray boxes.
- Never show broken image icons.

---

### 10.6 Link Button Group Component

Project buttons should be rendered conditionally.

If a URL is missing, hide its button automatically.

Supported optional buttons:

| Field | Button Label |
|---|---|
| `live_url` | Live Demo |
| `github_url` | GitHub |
| `case_study_url` | Case Study |
| `video_url` | Watch Video |

Rules:

- Do not show disabled buttons for missing links.
- If no links exist, do not show an empty button row.
- Keep mobile layout clean with wrapping or stacked buttons.

---

## 11. Page-Level Design Guidelines

## 11.1 Home Page

The homepage should be the strongest visual page.

Required sections:

1. Hero
2. Featured projects
3. Skills snapshot
4. Experience highlights
5. Process / how I work
6. Case study preview
7. Contact CTA

Hero design:

- Large heading
- Clear role statement
- CTA buttons
- Glass profile summary card
- Background grid and glow

Hero should answer:

- Who are you?
- What do you build?
- Why should someone trust you?
- What should the visitor do next?

---

## 11.2 Projects Page

Projects page should focus on clarity and filtering.

Layout:

- Page heading
- Short description
- Filter bar
- Responsive project grid

Project grid:

| Screen | Columns |
|---|---:|
| Mobile | 1 |
| Tablet | 2 |
| Desktop | 3 |

Rules:

- Project cards must have equal visual weight.
- Missing images must use gradient placeholders.
- Missing links must be hidden.
- Filters should not break mobile layout.

---

## 11.3 Project Detail Page

Project detail page should feel like a mini case study.

Recommended sections:

1. Project hero
2. Overview
3. Problem solved
4. Features
5. Tech stack
6. Architecture notes
7. Media section, optional
8. Links, optional
9. Results or impact
10. Related projects

Fallback layout:

If media is missing, use:

- Gradient hero visual
- Tech stack badges
- Strong content sections

---

## 11.4 Case Studies Pages

Case studies should look more editorial and serious.

Design rules:

- Use wider spacing
- Use readable article width
- Use strong headings
- Use callout panels for results/challenges
- Optional media should enhance, not interrupt

Article width:

```text
max-w-4xl
```

---

## 11.5 About Page

About page should build trust.

Recommended layout:

- Professional introduction
- Experience summary
- Technical strengths
- Work values
- Timeline or highlights
- CTA

Avoid making it too personal or too long.

---

## 11.6 Contact Page

Contact page should be simple and conversion-focused.

Required elements:

- Short CTA heading
- Contact form
- Direct contact options
- Social/profile links

Form fields:

- Name
- Email
- Subject
- Message
- Project type, optional

Design rules:

- Keep the form clean.
- Use clear validation errors.
- Show success confirmation.
- Do not ask for too many fields in the first version.

---

## 12. Admin UI Design Guidelines

Admin design should be clean, functional, and less decorative than the public website.

Admin design principles:

- Prioritize clarity
- Keep actions visible
- Use tables and forms cleanly
- Avoid heavy animations
- Use status badges
- Use confirmation dialogs for destructive actions

Admin layout:

| Area | Purpose |
|---|---|
| Sidebar | Navigation |
| Header | Current page title and user actions |
| Main area | Tables, forms, dashboard cards |
| Action bar | Create, filter, search, save |

Admin pages:

- Login
- Dashboard
- Projects list
- Project create/edit
- Case studies list
- Case study create/edit
- Contact inquiries

Admin visual style:

- Dark theme can be reused
- Use flatter cards
- Reduce glow effects
- Keep spacing generous
- Make forms easy to scan

---

## 13. Animation System

Animations should be subtle, smooth, and purposeful.

Recommended library:

- Framer Motion

### 13.1 Animation Principles

Use animation for:

- Section entrance
- Card hover
- Button hover
- Page transitions, optional
- Mobile menu
- Modal/dialog appearance

Avoid animation for:

- Every small text block
- Constant moving objects
- Fast particles
- Distracting background movement

### 13.2 Motion Presets

Fade up:

```ts
{
  initial: { opacity: 0, y: 24 },
  animate: { opacity: 1, y: 0 },
  transition: { duration: 0.5, ease: "easeOut" }
}
```

Card hover:

```ts
{
  whileHover: { y: -4 },
  transition: { duration: 0.2, ease: "easeOut" }
}
```

Stagger container:

```ts
{
  animate: {
    transition: {
      staggerChildren: 0.08
    }
  }
}
```

### 13.3 Accessibility Rule

Respect reduced motion preferences.

If a user has reduced motion enabled:

- Disable background movement
- Reduce entrance animations
- Keep hover states simple

---

## 14. Responsive Design Rules

The portfolio must work beautifully on mobile, tablet, laptop, and desktop.

### 14.1 Breakpoint Strategy

Use Tailwind default breakpoints:

| Breakpoint | Width |
|---|---:|
| `sm` | 640px |
| `md` | 768px |
| `lg` | 1024px |
| `xl` | 1280px |
| `2xl` | 1536px |

### 14.2 Mobile Rules

On mobile:

- Use one-column layouts
- Stack CTA buttons if needed
- Keep text readable
- Avoid tiny badges
- Reduce section padding
- Keep navbar simple
- Make touch targets large enough

Minimum touch target:

```text
44px x 44px
```

### 14.3 Desktop Rules

On desktop:

- Use stronger layout contrast
- Allow 2–3 column grids
- Use larger headings
- Increase section spacing
- Keep text blocks from becoming too wide

---

## 15. Accessibility Rules

Accessibility is part of production quality.

Minimum requirements:

- Clear color contrast
- Keyboard focus states
- Semantic HTML
- Descriptive alt text for images
- Form labels
- Error messages connected to fields
- Reduced motion support
- Buttons must be real buttons
- Links must be real links

Contrast rule:

- Body text should meet WCAG AA contrast where possible.
- Avoid low-opacity text on gradient backgrounds.

Image rule:

- If image is decorative, use empty alt text.
- If image communicates project context, use meaningful alt text.

---

## 16. Empty, Loading, and Error States

Production UI must handle all states gracefully.

### 16.1 Empty States

Examples:

- No projects available
- No case studies published
- No contact inquiries in admin
- No media for project

Empty state should include:

- Simple icon or subtle visual
- Clear message
- Optional next action

### 16.2 Loading States

Use:

- Skeleton cards
- Loading button states
- Soft shimmer only if subtle

Avoid:

- Full-page spinners everywhere
- Layout jumps after loading

### 16.3 Error States

Error state should include:

- Clear message
- Recovery action
- No technical stack trace for users

Examples:

- Could not load projects
- Could not submit contact form
- Project not found

---

## 17. Project Media Rules

Project media must be optional.

Supported optional fields:

- Thumbnail image
- Gallery images
- Video URL
- Live URL
- GitHub URL
- Case study URL

Rules:

- Missing thumbnail shows gradient placeholder.
- Missing video hides video button/section.
- Missing live URL hides live demo button.
- Missing GitHub URL hides GitHub button.
- Missing case study URL hides case study button.
- Project card should never look broken due to missing media.

Professional fallback priority:

1. Show thumbnail if available
2. Else show generated gradient placeholder
3. Else show title initials/category icon

---

## 18. Tailwind Implementation Plan

The design system should be implemented in Tailwind during the frontend setup phase.

Recommended Tailwind theme areas:

```ts
theme: {
  extend: {
    colors: {},
    fontFamily: {},
    boxShadow: {},
    backgroundImage: {},
    borderRadius: {},
    keyframes: {},
    animation: {}
  }
}
```

Suggested custom utilities/components later:

- `.glass-card`
- `.glow-border`
- `.section-padding`
- `.container-page`
- `.gradient-placeholder`
- `.text-gradient`

Do not overuse custom CSS if Tailwind utilities can handle it cleanly.

---

## 19. Reusable Frontend Components

Design system components should be created before full page development.

Recommended component structure:

```text
frontend/components/
  ui/
    Button.tsx
    Card.tsx
    Badge.tsx
    Container.tsx
    SectionHeading.tsx
    EmptyState.tsx
    GradientPlaceholder.tsx
    LinkButtonGroup.tsx
  effects/
    AnimatedGridBackground.tsx
    GradientGlow.tsx
    GlassPanel.tsx
    GlowBorderCard.tsx
    NoiseOverlay.tsx
  layout/
    Navbar.tsx
    Footer.tsx
    MainLayout.tsx
    AdminLayout.tsx
```

Rules:

- Components should be reusable.
- Components should use TypeScript props.
- Components should support optional class names.
- Components should not contain hardcoded project data.
- Project data should come from API or typed mock data during early development.

---

## 20. Design QA Checklist

Before marking any UI phase complete, check:

### Visual Quality

- [ ] Does the page look premium and professional?
- [ ] Are gradients subtle?
- [ ] Are glass cards readable?
- [ ] Are cards aligned consistently?
- [ ] Is spacing balanced?
- [ ] Are sections visually separated?

### Responsiveness

- [ ] Mobile layout works properly
- [ ] Tablet layout works properly
- [ ] Desktop layout works properly
- [ ] No horizontal scrolling
- [ ] Buttons and badges wrap correctly

### Content Handling

- [ ] Project without image still looks good
- [ ] Missing project links are hidden
- [ ] Empty project list has proper empty state
- [ ] Long project titles do not break layout
- [ ] Long descriptions are truncated where needed

### Accessibility

- [ ] Text contrast is readable
- [ ] Keyboard focus is visible
- [ ] Forms have labels
- [ ] Images have alt text
- [ ] Reduced motion is respected

### Performance

- [ ] No heavy animation loops
- [ ] Images are optimized
- [ ] Background effects are lightweight
- [ ] No unnecessary client-side rendering

---

## 21. First Implementation Scope for Design System Phase

When implementation begins, keep the first design system phase small.

Allowed initial work:

- Configure Tailwind theme tokens
- Add global background styles
- Create reusable Button component
- Create reusable Card component
- Create Container component
- Create SectionHeading component
- Create Badge component
- Create GradientPlaceholder component
- Create basic AnimatedGridBackground component
- Create one sample page section to verify the system

Do not build full pages yet.

Do not build admin UI yet.

Do not connect API yet.

---

## 22. Codex Prompt for Implementing This Phase Later

Use this prompt later when asking Codex to implement the design system.

```text
Task:
Implement the initial frontend design system for the portfolio app.

Context:
Use docs/03-design-system.md as the source of truth.

Scope:
You may modify only:
- frontend/tailwind.config.ts
- frontend/app/globals.css
- frontend/components/ui/
- frontend/components/effects/
- frontend/components/layout/ if required for basic layout

Requirements:
- Add Tailwind theme tokens for colors, spacing, shadows, gradients, and typography.
- Create reusable Button, Card, Badge, Container, SectionHeading, and GradientPlaceholder components.
- Create subtle AnimatedGridBackground and GradientGlow components.
- Use TypeScript.
- Keep components reusable and clean.
- Support optional className props.
- Keep animations subtle.
- Respect accessibility basics such as focus states and readable contrast.

Do not:
- Build full public pages yet.
- Build the admin panel yet.
- Connect to Laravel API yet.
- Add hardcoded project data except minimal sample content if needed for visual testing.
- Modify unrelated files.

After implementation:
- List all changed files.
- Explain what was added.
- Explain how to preview the design system locally.
- Mention any pending improvements.
```

---

## 23. Final Design System Rule

Every future UI decision should pass this question:

> Does this make the portfolio look more professional, trustworthy, and easier to understand?

If the answer is no, do not add it.

