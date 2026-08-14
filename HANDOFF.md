# Project Agent Handoff & Technical Guide — İpek Mühendislik

> **Document Purpose:** This handoff document summarizes the architecture, technical patterns, established skills, conventions, recent updates, and user constraints for the **İpek Mühendislik** web application project so that any AI agent or developer can seamlessly continue development.

---

## 1. Project Overview & Tech Stack

- **Framework:** Laravel 13.x (PHP 8.3+)
- **Database:** MySQL / MariaDB (Migration & Seed compliant)
- **Frontend Architecture:** Blade Templating, Vanilla CSS, Bootstrap 5, Custom SVG Icon system (`render_svg_icon()`), FontAwesome 6, TinyMCE editor, Dropify image uploader.
- **Admin Architecture:** Custom Glassmorphism Dark/Enterprise UI, unified CRUD base services, multilingual translation tabs.
- **Primary Languages:** Turkish (`tr` - Default), English (`en`).

---

## 2. Core Architectural Patterns & Skills (Skiller)

### A. Multilingual Translation Trait (`App\Traits\HasTranslation`)
- **Pattern:** Every translatable entity (Services, Projects, Blog Posts, Pages, Categories, Site Modals, Menu Items) uses the `HasTranslation` trait and has a corresponding `*_translations` table and Eloquent model in `App\Models\Translations\*Translation`.
- **Slug Routing:** Multilingual slug resolution across locales is integrated in `HasTranslation` and handled seamlessly in `FrontendController.php`.
- **Locale Fallback:** Dynamic fallback checks translation model for active locale (`App::getLocale()`), falling back to base model columns (`tr`).

### B. Service Pattern (`App\Services\BaseService`)
- **Pattern:** All business logic, CRUD, pagination, and media handling reside in Service classes inheriting from `BaseService`.
- **Image Processing:** `BaseService` automatically handles WebP conversions, file resizing (`$imageWidth`, `$imageHeight`), and storage under `storage/app/public/uploads/*`.
- **Service Classes:**
  - `PageService.php`
  - `ServiceService.php`
  - `ProjectService.php`
  - `BlogPostService.php`
  - `CategoryService.php`

### C. Dynamic SEO & Title Architecture
- **Policy:** Page titles are built dynamically in `master.blade.php`: `<title>@hasSection('title')@yield('title') — @endif @setting('site_title')</title>`.
- **No Hardcoded Company Names:** Subviews specify only their logical title (`@section('title', __('İletişim & Teklif'))` or `@section('title', $item->title)`) and localized description (`@section('meta_description', __('...'))`). Static strings containing specific brand names must NEVER be hardcoded into view files or fallback parameters so the software remains 100% white-label and multi-language ready across different installations/brands.
- **Database Schema:** Redundant `meta_title` columns are dropped. Content `title` is the single source of truth.

### D. Module-Agnostic Category Management
- **Pattern:** Centrally managed categories (`Category` model) associated with Blog Posts, Projects, Services via `category_id`.
- **Admin UI:** Unified category CRUD under `/admin/categories`.

### E. Standardized Site Settings Access (`@setting()` & `setting()`)
- **Policy:** Never write `@php $var = \App\Models\Setting::get(...) @endphp` inside Blade templates.
- **Blade Directive:** `@setting('key')`
- **PHP Helper:** `setting('key')`
- **Zero Static Fallbacks:** Do NOT hardcode company names/addresses as default fallback arguments in view files. All branding and metadata values must be fetched dynamically from the database.
- **Implementation:** Registered in `app/Providers/AppServiceProvider.php` & `app/helpers.php`.

---

## 3. Critical User Directives & Constraints

1. **NO BROWSER SUBAGENTS / AUTOMATED TESTING:**
   - **Do NOT launch browser automation/subagents or perform browser interaction checks.**
   - Rely strictly on PHP CLI, Laravel Artisan commands (`php artisan`), log checks, and code inspection.
2. **Title-Based SEO & White-Label Titles:**
   - Do NOT re-add `meta_title` inputs or columns.
   - Do NOT hardcode company/brand names in view title sections or fallback parameters. `<title>` is dynamically concatenated with `@setting('site_title')`.
3. **Settings Access Standard:**
   - Always use `@setting('key')` or `setting('key')` in Blade templates; avoid inline `@php $var = Setting::get(...) @endphp` or hardcoded fallback strings.
4. **Clean Code & Comments Preservation:**
   - Maintain existing docstrings, non-destructive migrations, and clear clean code structure.

---

## 4. Key File Map

| Component | Path | Description |
| :--- | :--- | :--- |
| **Helpers** | `app/helpers.php` | Global helpers (`render_svg_icon()`, `setting()`, `__t()`) |
| **AppServiceProvider** | `app/Providers/AppServiceProvider.php` | Registers `@svg`, `@setting` Blade directives |
| **Header Partial** | `resources/views/frontend/partials/header.blade.php` | Topbar, nav, desktop & mobile flag language switchers |
| **Footer Partial** | `resources/views/frontend/partials/footer.blade.php` | Site footer with translated labels & `@setting` calls |
| **Page Model** | `app/Models/Page.php` | Page entity with `HasTranslation` trait |
| **Page Translation** | `app/Models/Translations/PageTranslation.php` | Translatable fields for pages |
| **Page Service** | `app/Services/PageService.php` | Business logic & image uploads for static pages |
| **Page Controller** | `app/Http/Controllers/Admin/PageController.php` | Admin page management |
| **Frontend Controller** | `app/Http/Controllers/FrontendController.php` | Public routes & locale detail pages |
| **Admin Views** | `resources/views/admin/pages/` | Create, Edit, Index blade templates |
| **Frontend Views** | `resources/views/frontend/` | Public detail pages (`about`, `services`, `service-detail`, `projects`, `project-detail`, `blog`, `blog-detail`, `contact`, `page-detail`) |

---

## 5. Recent Changes Summary

- **Standardized English Controller & Blade Naming:** Refactored `FrontendController.php` methods (`about()`, `services()`, `serviceDetail()`, `projects()`, `projectDetail()`, `contact()`, `pageDetail()`) and all corresponding Blade view files (`about.blade.php`, `services.blade.php`, `service-detail.blade.php`, `projects.blade.php`, `project-detail.blade.php`, `blog-detail.blade.php`, `contact.blade.php`, `page-detail.blade.php`) to 100% clean English PSR conventions.
- **Enterprise Security & OWASP Hardening:** Added `SecurityHeadersMiddleware`, rate limiting (`throttle:10,1` on forms, `throttle:5,1` on admin login), honeypot spam protection, and XSS input sanitization.
- **Dedicated FormRequest Layer:** Created `StoreMessageRequest`, `StoreQuoteRequest`, and `StoreCommentRequest` for robust decoupled validation.
- **UI/UX Pro Max & SEO:** Integrated dynamic `<html lang="...">`, Open Graph / Twitter Card tags, brand vector SVGs, `:focus-visible` accessibility, and double-click prevention with loading spinners.
- **Consolidated Database Migrations:** Merged all incremental `add_*` / `drop_*` migrations into clean, consolidated table creation migrations (`2026_08_08_000000_create_categories_table.php`, `create_services_table.php`, `create_projects_table.php`, `create_blog_posts_table.php`, `create_menu_items_table.php`, `create_pages_table.php`).
- **Cleaned Models & Admin Views:** Removed `meta_title` from `$fillable`, getter accessors, and admin forms in `create.blade.php`, `edit.blade.php`, and `index.blade.php`.
- **Updated Frontend Views:** Updated title headers in `sayfa-detay.blade.php`, `hizmet-detay.blade.php`, `proje-detay.blade.php`, `blog-detay.blade.php` to use `$item->title` directly.
- **Multilingual Flag Icons & Language Switcher:** Added country flag icons (`🇹🇷` / `🇬🇧`) and globe symbol to the language switcher dropdown in both desktop topbar and mobile navigation (`header.blade.php`). Expanded `lang/tr.json` and `lang/en.json` with complete footer/header translation keys.
- **Standardized `@setting()` Directive:** Created global `setting('key', 'default')` helper in `app/helpers.php` and `@setting('key', 'default')` directive in `AppServiceProvider.php`. Replaced all inline `\App\Models\Setting::get()` calls across Blade views.
