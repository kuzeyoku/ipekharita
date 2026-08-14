---
name: laravel-best-practices
description: >-
  Comprehensive guide and ruleset for Laravel 11/12/13+ enterprise development.
  Use this skill whenever creating, modifying, or refactoring Laravel code, including
  Controllers, Models, Services, FormRequests, Migrations, Seeders, Eloquent relationships,
  Blade views, Routing, Testing (Pest/PHPUnit), Caching, and Queue jobs.
---

# Laravel Best Practices & Architecture Skill

Production-grade development guidelines and conventions for modern Laravel applications.

---

## 1. Architectural Principles: "Thin Controllers, Rich Services"

- **Controllers:** Controllers should ONLY accept HTTP requests, validate input (or delegate to FormRequest), invoke the relevant Service class, and return a View or JSON Response.
- **Service Layer (`App\Services`):** All business logic, database mutations, external API calls, and file/image manipulation must reside in dedicated Service classes (e.g. `BaseService`, `ImageService`, `PageService`).
- **FormRequests:** Avoid inline `$request->validate()` in controllers. Use dedicated `app/Http/Requests/*` FormRequest classes for complex validation rules.

```php
// ✅ Correct Controller Pattern
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateServiceRequest;
use App\Services\ServiceService;
use Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    public function __construct(protected ServiceService $serviceService) {}

    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        $this->serviceService->update($id, $request->validated());
        return redirect()->route('admin.services.index')->with('success', __('İşlem başarıyla tamamlandı.'));
    }
}
```

---

## 2. Eloquent ORM & Database Performance

- **Prevent N+1 Query Problem:** Always eager-load relationships when querying collections:
  ```php
  // ✅ Good: Eager load relationships
  $posts = BlogPost::with(['category', 'translations'])->where('is_active', true)->paginate(12);
  ```
- **Mass Assignment:** Explicitly define `$fillable` on all Eloquent models. Never use `$guarded = []` on models exposed to request input.
- **Transactions:** Wrap multi-table operations or cascading updates in database transactions:
  ```php
  DB::transaction(function () use ($data) {
      $item = Model::create($data['base']);
      $item->translations()->createMany($data['translations']);
  });
  ```
- **Chunking & Lazy Loading:** Use `chunk()` or `lazy()` for large datasets to prevent memory exhaustion.

---

## 3. Multilingual & Translation Standards (`HasTranslation`)

- All translatable models must utilize the `App\Traits\HasTranslation` trait and corresponding `*_translations` child tables.
- **Slug Resolution:** Slugs must be resolved dynamically against the active locale with automatic fallback to default locale (`tr`).
- **Template Fallback:** Always access translatable fields through model accessors (e.g., `$item->title`, `$item->summary`) which automatically resolve the active locale.

---

## 4. Blade Templating & Settings Access

- **No Hardcoded Company Names / Fallbacks:** Keep the application 100% white-label. Always retrieve site branding and metadata dynamically.
- **Blade Directives:** Use `@setting('key')` or `setting('key')` for system settings. Never write inline `@php $var = Setting::get(...) @endphp`.
- **SVG Vector Icons:** Use the optimized `render_svg_icon('icon-name')` helper or `@svg` directive. Never load heavy font stylesheets if inline SVGs are available.
- **Static Site Texts:** Use `__t('key', 'default', 'group')` for local zero-query static translations.

---

## 5. Security & Validation

- **Strict Type Declarations:** Use `declare(strict_types=1);` in all new PHP classes.
- **XSS Prevention:** Use Blade's `{{ $escaped }}` for all dynamic output. Only use `{!! $rawHtml !!}` for sanitized rich-text content from trusted editors.
- **CSRF Protection:** Ensure `@csrf` is present in all POST/PUT/DELETE forms.
- **File Upload Security:** Validate MIME types, file extensions, and file sizes. Process and convert all uploaded images to WebP format via `ImageService`.
- **Authorization:** Enforce permissions and model-level access via Laravel Policies and Gates (`Gate::authorize()`).

---

## 6. Testing & Quality Assurance

- Maintain feature tests in `tests/Feature/` covering critical endpoints (Authentication, Public Detail Pages, Admin CRUD, Contact/Quote forms).
- Run `php artisan test` before deploying changes to ensure zero regressions.
