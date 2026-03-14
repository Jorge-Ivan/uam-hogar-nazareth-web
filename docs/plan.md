# Plan: Hogar Nazareth — Hoja de Ruta de Implementación

> **Documento vivo.** Marcar cada ítem con `[x]` al completarlo.
> Última revisión: 2026-03-14

---

## Estado General del Proyecto

| Componente | Estado |
|---|---|
| Documentación (4 archivos) | ✅ Completa |
| Laravel app (`composer.json`, `artisan`, etc.) | ✅ Completa |
| Migraciones (10 entidades) | ✅ Completa |
| Modelos Eloquent | ✅ Completa |
| Servicios y Actions | ❌ No existe |
| Panel admin (Livewire) | ❌ No existe |
| Sitio web público (Blade) | ❌ No existe |
| API REST | ❌ No existe |
| Tests (Pest) | ❌ No existe |

---

## Grafo de Dependencias

```
Fase 0 (Fundación: Laravel + BD + Modelos)
    ↓
Fase 1 (Media: MediaService + OptimizeImage)
    ↓
Fase 2 (Backend: Services + Actions + Policies)
    ↓
Fase 3 (Admin Panel Livewire) ← ★ HITO: DEMO FUNCIONAL
    ↓
Fase 4 (Sitio Público)    Fase 5 (API REST)  ← paralelas
           ↓                      ↓
         Fase 6 (Pulido + Producción)
```

---

## Fase 0 — Fundación

**Objetivo:** Laravel funcional con esquema completo y todos los modelos.

### 0.1 Instalación y configuración
- [x] `composer create-project laravel/laravel hogarnazareth`
- [x] Configurar `.env`: MySQL, `QUEUE_CONNECTION=database`, `APP_LOCALE=es`
- [x] `config/filesystems.php` + `php artisan storage:link`

### 0.2 Paquetes
- [x] `composer require livewire/livewire:^3 intervention/image:^2`
- [x] `composer require --dev pestphp/pest pestphp/pest-plugin-laravel`
- [x] `npm install -D tailwindcss @tailwindcss/forms @tailwindcss/typography autoprefixer postcss`
- [x] `php artisan pest:install`
- [x] `php artisan queue:table && php artisan queue:failed-table`
- [x] `tailwind.config.js` y `vite.config.js` configurados

### 0.3 Enums
- [x] `app/Enums/ContentStatus.php` — casos: `Draft`, `Published`, `Archived`
- [x] `app/Enums/UserRole.php` — casos: `Admin`, `Editor`

### 0.4 Migraciones (orden por FK)
- [x] `create_media_table`
- [x] `create_users_table` (+ columna `role` via `add_role_to_users_table`)
- [x] `create_document_categories_table`
- [x] `create_document_years_table`
- [x] `create_pages_table` (status, published_at)
- [x] `create_activities_table` (featured_image_id → media)
- [x] `create_galleries_table`
- [x] `create_gallery_images_table` (gallery_id, media_id, position)
- [x] `create_events_table` (featured_image_id → media)
- [x] `create_documents_table` (3 FKs: category, year, media)
- [x] `create_jobs_table` / `create_failed_jobs_table`
- [x] `php artisan migrate` ✅ sin errores

### 0.5 Modelos Eloquent
- [x] `app/Models/Media.php`
- [x] `app/Models/User.php` (cast `role` → `UserRole`)
- [x] `app/Models/Page.php` (cast `status` → `ContentStatus`, `scopePublished`)
- [x] `app/Models/Activity.php` (belongsTo Media, ContentStatus, `scopePublished`)
- [x] `app/Models/Gallery.php` (hasMany GalleryImage)
- [x] `app/Models/GalleryImage.php` (belongsTo Gallery, Media)
- [x] `app/Models/Event.php` (belongsTo Media)
- [x] `app/Models/Document.php` (belongsTo Category, Year, Media)
- [x] `app/Models/DocumentCategory.php` (hasMany Document)
- [x] `app/Models/DocumentYear.php` (hasMany Document)

### 0.6 Auth base
- [x] `php artisan sanctum:install` (Sanctum incluido en Laravel 10)
- [x] `app/Http/Middleware/AdminMiddleware.php`
- [x] Esqueleto de rutas en `routes/web.php` y `routes/api.php`

### Verificación Fase 0
- [x] `php artisan migrate:status` → todas en batch
- [x] `php artisan route:list` → sin errores
- [ ] Smoke tests de modelos pasan

---

## Fase 1 — Infraestructura de Media

**Objetivo:** Pipeline de subida completo. Todo contenido depende de esto.

- [ ] `app/Services/MediaService.php`
  - `upload(UploadedFile, string $dir): Media`
  - `delete(Media): void`
  - `getUrl(Media): string`
- [ ] `app/Jobs/OptimizeImage.php` (ShouldQueue, `$tries = 3`)
- [ ] `app/Actions/UploadMedia.php`
- [ ] `app/Http/Requests/UploadMediaRequest.php` (mensajes en español)
- [ ] `app/Http/Resources/MediaResource.php`

### Verificación Fase 1
- [ ] Feature test: subir imagen → Media creado + job despachado
- [ ] Feature test: subir PDF → sin job de imagen
- [ ] Unit test: `OptimizeImage` procesa fixture sin error

---

## Fase 2 — Backend de Contenido

**Objetivo:** Services, Actions y Policies para todos los módulos. Sin UI aún.

### Pages
- [ ] `app/Services/PageService.php` (create, update, publish, archive)
- [ ] `app/Actions/CreatePage.php`, `UpdatePage.php`, `PublishPage.php`
- [ ] `app/Http/Requests/StorePageRequest.php`, `UpdatePageRequest.php`
- [ ] `app/Policies/PagePolicy.php`

### Activities
- [ ] `app/Services/ActivityService.php`
- [ ] `app/Actions/CreateActivity.php`, `UpdateActivity.php`, `PublishActivity.php`, `SetActivityFeaturedImage.php`
- [ ] `app/Http/Requests/StoreActivityRequest.php`, `UpdateActivityRequest.php`
- [ ] `app/Policies/ActivityPolicy.php`

### Galleries
- [ ] `app/Services/GalleryService.php` (create, update, addImage, removeImage, reorderImages)
- [ ] `app/Actions/CreateGallery.php`, `AddGalleryImage.php`, `ReorderGalleryImages.php`, `RemoveGalleryImage.php`
- [ ] `app/Http/Requests/StoreGalleryRequest.php`, `AddGalleryImageRequest.php`
- [ ] `app/Policies/GalleryPolicy.php`

### Events
- [ ] `app/Services/EventService.php`
- [ ] `app/Actions/CreateEvent.php`, `UpdateEvent.php`
- [ ] `app/Http/Requests/StoreEventRequest.php` (validar start_date ≤ end_date)
- [ ] `app/Policies/EventPolicy.php`

### Documents
- [ ] `app/Services/DocumentService.php`
- [ ] `app/Actions/CreateDocument.php`, `UpdateDocument.php`
- [ ] `app/Http/Requests/StoreDocumentRequest.php`
- [ ] `app/Policies/DocumentPolicy.php`

### Auth
- [ ] Registrar todas las Policies en `app/Providers/AuthServiceProvider.php`

### Verificación Fase 2
- [ ] Unit tests Services: CRUD + transiciones de estado
- [ ] Unit test: Policy deniega a editor en operaciones de admin
- [ ] Unit test: `ActivityService::publish()` establece `published_at`
- [ ] Unit test: `GalleryService::reorderImages()` actualiza posiciones

---

## Fase 3 — Panel de Administración ★ HITO

**Objetivo:** Panel Livewire completo para personal no técnico.

### Layout y auth
- [ ] `resources/views/layouts/admin.blade.php` (sidebar Tailwind, nav en español)
- [ ] `resources/views/auth/login.blade.php` ("Iniciar sesión")
- [ ] `app/Http/Controllers/Admin/DashboardController.php`
- [ ] `resources/views/admin/dashboard.blade.php` (conteos + actividades recientes)

### Livewire — Pages
- [ ] `app/Livewire/Admin/PageTable.php` (búsqueda, paginación, filtro estado, eliminar)
- [ ] `app/Livewire/Admin/PageForm.php` (crear/editar, slug auto, estado)
- [ ] Vistas blade correspondientes

### Livewire — Activities
- [ ] `app/Livewire/Admin/ActivityTable.php` (búsqueda, filtro, publicar inline)
- [ ] `app/Livewire/Admin/ActivityForm.php` (título, slug, excerpt, contenido, imagen, fecha)
- [ ] Vistas blade correspondientes

### Livewire — Galleries
- [ ] `app/Livewire/Admin/GalleryTable.php`
- [ ] `app/Livewire/Admin/GalleryManager.php` (subir imágenes, reordenar con Alpine Sortable, eliminar)
- [ ] Vista blade correspondiente

### Livewire — Events
- [ ] `app/Livewire/Admin/EventTable.php`
- [ ] `app/Livewire/Admin/EventForm.php` (fechas, ubicación, imagen)
- [ ] Vistas blade correspondientes

### Livewire — Documents
- [ ] `app/Livewire/Admin/DocumentTable.php` (filtro categoría/año)
- [ ] `app/Livewire/Admin/DocumentUploader.php` (categoría, año, subir PDF)
- [ ] Vistas blade correspondientes

### Rutas admin
- [ ] `/admin/dashboard`
- [ ] `/admin/pages` (index, create, edit)
- [ ] `/admin/activities` (index, create, edit)
- [ ] `/admin/galleries` (index, create, manage)
- [ ] `/admin/events` (index, create, edit)
- [ ] `/admin/documents` (index, create)

### Verificación Fase 3
- [ ] Feature test: `ActivityForm` crea registro vía `ActivityService`
- [ ] Feature test: `GalleryManager` sube imagen y crea `GalleryImage`
- [ ] Feature test: rutas admin sin auth → redirige login
- [ ] **Manual:** staff puede crear y publicar todos los tipos de contenido

---

## Fase 4 — Sitio Web Público

**Objetivo:** Exposición pública del contenido gestionado.

### Layout
- [ ] `resources/views/layouts/public.blade.php` (header nav español, footer, hamburger Alpine)

### Controladores y vistas
- [ ] `Website/HomeController` → `/` (hero + últimas actividades + próximos eventos)
- [ ] `Website/ActivityController` → `/actividades`, `/actividades/{slug}`
- [ ] `Website/GalleryController` → `/galerias`, `/galerias/{slug}` (lightbox Alpine)
- [ ] `Website/EventController` → `/eventos`, `/eventos/{slug}`
- [ ] `Website/DocumentController` → `/transparencia` (agrupado por año y categoría)
- [ ] `Website/PageController` → `/paginas/{slug}`
- [ ] Vistas estáticas: `/donaciones`, `/contacto`

### SEO básico
- [ ] `@section('title')` y `@section('description')` por vista
- [ ] Open Graph tags en actividades y galerías

### Verificación Fase 4
- [ ] Feature test: `GET /actividades` → solo publicadas
- [ ] Feature test: `GET /actividades/{slug}` draft → 404
- [ ] Feature test: galería sin N+1

---

## Fase 5 — API REST

**Objetivo:** Endpoints `/api/v1/` para integraciones futuras.

### API Resources
- [ ] `ActivityResource`, `ActivityCollection`
- [ ] `GalleryResource`, `GalleryImageResource`
- [ ] `EventResource`
- [ ] `DocumentResource`
- [ ] `PageResource`

### Controladores API
- [ ] `Api/V1/ActivityController`
- [ ] `Api/V1/GalleryController`
- [ ] `Api/V1/EventController`
- [ ] `Api/V1/DocumentController`
- [ ] `Api/V1/PageController`

### Rutas `/api/v1/`
- [ ] Endpoints públicos GET (activities, galleries, events, documents, pages)
- [ ] Endpoints protegidos POST/PUT/DELETE (`auth:sanctum`)

### Verificación Fase 5
- [ ] Feature test: `GET /api/v1/activities` → JSON paginado correcto
- [ ] Feature test: draft → 404 en API
- [ ] Feature test: `POST` sin token → 401

---

## Fase 6 — Pulido y Producción

**Objetivo:** Calidad, rendimiento, seguridad, accesibilidad.

### Seeders (contenido en español)
- [ ] `UserSeeder` (1 admin, 1 editor)
- [ ] `PageSeeder` (Quiénes Somos, Misión, Servicios)
- [ ] `ActivitySeeder` (10 actividades de ejemplo)
- [ ] `GallerySeeder` (3 galerías con imágenes)
- [ ] `EventSeeder` (pasado, presente, futuro)
- [ ] `DocumentSeeder` (documentos de transparencia)

### Rendimiento
- [ ] `Cache::remember()` en controllers públicos (TTL 5 min)
- [ ] Limpiar caché en publish (Service layer)
- [ ] Auditoría N+1 completa con Debugbar/Telescope

### Calidad
- [ ] Páginas de error en español (`404`, `500`, `403`)
- [ ] `lang/es/validation.php`, `lang/es/auth.php`
- [ ] `app/Console/Kernel.php` — Scheduler configurado

### Seguridad
- [ ] Middleware `auth` en todas las rutas admin
- [ ] Validación MIME server-side en uploads
- [ ] CSRF en todos los formularios confirmado

### Accesibilidad
- [ ] `alt` text desde `Media::alt_text` en todas las imágenes
- [ ] HTML semántico (`<nav>`, `<main>`, `<article>`, `<section>`)

### Suite de tests final (objetivo 80%+ cobertura)
- [ ] `Unit/Services/` — todos los services
- [ ] `Unit/Actions/UploadMediaTest.php`
- [ ] `Feature/Admin/` — auth, pages, activities, galleries, documents
- [ ] `Feature/Website/` — home, activities, galleries, documents
- [ ] `Feature/Api/V1/` — activities, galleries

---

## Archivos de Referencia Críticos

- [domain-model.md](domain-model.md) — Fuente de verdad para migraciones y relaciones
- [laravel-architecture-guide.md](laravel-architecture-guide.md) — Patrones: Model, Livewire, Service, API Resource
- [architecture.md](architecture.md) — URLs, roles, flujo de publicación
- [../CLAUDE.md](../CLAUDE.md) — Convenciones: español en UI, MediaService obligatorio, estructura de dirs
- [project-context.md](project-context.md) — Contexto para seeders y copy de UI

---

## Convenciones No Negociables

- `declare(strict_types=1)` en todos los archivos PHP
- Lógica de negocio en Services/Actions, nunca en Controllers
- Toda subida de archivos pasa por `MediaService`
- Toda optimización de imágenes via `OptimizeImage` job (queued)
- `ContentStatus` enum en entidades con flujo draft/published/archived
- Slugs obligatorios en: Page, Activity, Gallery, Event
- UI del admin y mensajes de error en español
- Nunca modificar migraciones existentes — siempre crear nuevas
