# Hogar Nazareth Web Platform

## Project
Redesign of the Fundación Hogar del Anciano Nazareth website.
Dynamic Laravel platform manageable by non-technical staff.

Current site: https://fundaciondelancianonazareth.com/

## Documentation
- Project context: @docs/project-context.md
- Laravel architecture: @docs/laravel-architecture-guide.md
- System architecture: @docs/architecture.md
- Domain model: @docs/domain-model.md
- Implementation roadmap: @docs/plan.md
- Design guide: @docs/design-guide.md — colors, typography, UI patterns, admin layout. Load before writing any Blade view.

## Stack
- Laravel 10+ / PHP 8.2+
- MySQL
- Livewire (admin interactivity)
- Blade + Tailwind CSS
- Sanctum (API auth)
- Database queues + Laravel Scheduler
- Pest / PHPUnit

## Commands
- Tests: `php artisan test`
- Server: `php artisan serve`
- Migrations: `php artisan migrate`
- Check migrations: `php artisan migrate:status`
- Check routes: `php artisan route:list`
- Run queue: `php artisan queue:work --once`
- Clear cache: `php artisan optimize:clear`

## Project Structure
```
app/
├── Actions/       # Single-responsibility operations
├── Enums/         # Status enums (ContentStatus, etc.)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   └── Website/
│   ├── Requests/  # All validation here
│   └── Resources/ # API resources
├── Jobs/          # Queued background tasks
├── Livewire/      # Admin interactive components
├── Models/        # Eloquent models only
├── Policies/      # Authorization
├── Services/      # Business logic
└── Support/
```

## Core Models
Page, Activity, Gallery, GalleryImage, Event, Document,
DocumentCategory, DocumentYear, Media, User

Always consult @docs/domain-model.md before creating models or migrations.

## Conventions
- Business logic in Services or Actions, never in Controllers
- Validation in Form Requests only
- Authorization in Policies only
- Long-running tasks in Jobs (queues)
- Always eager load relationships — no N+1
- Use enums for status fields (draft/published/archived)
- Never modify existing migrations, always create new ones
- Use typed properties and strict types (PSR-12)
- Slugs required on: Page, Activity, Gallery, Event

## Feature Workflow
1. Analyse requirements
2. Design database schema → consult @docs/domain-model.md
3. Implement Eloquent models
4. Build Services and Actions
5. Implement Controllers (thin)
6. Implement Livewire components if needed
7. Add queued Jobs for heavy tasks
8. Write Pest tests

## Language
- All user-facing content, UI labels, messages, and views must be in **Spanish**
- Database seeders and placeholder content in Spanish
- Validation error messages in Spanish
- Admin panel interface in Spanish
- Code, comments, and variable names remain in English

## Warnings
- Admin panel used by non-technical staff — prioritize simplicity
- Media (images, documents) is central — always go through MediaService
- Image optimization must be queued via OptimizeImage job
- API routes follow /api/v1/ prefix with API Resources
- **`docs/superpowers/` must never be committed** — delete it before the final commit of any plan or task. It contains session artifacts (implementation plans, subagent prompts) that must not appear in the repository history.

## Current Status
Check @docs/plan.md for the full implementation roadmap and current progress.
Start every session by checking which phase is active before writing any code.