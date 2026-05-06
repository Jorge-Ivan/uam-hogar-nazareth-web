# Plan: Hogar Nazareth — Hoja de Ruta de Implementación

> **Documento vivo.** Marcar cada ítem con `[x]` al completarlo.
> Última revisión: 2026-04-19

---

## Estado General del Proyecto

| Componente | Estado |
|---|---|
| Documentación (4 archivos) | ✅ Completa |
| Laravel app (`composer.json`, `artisan`, etc.) | ✅ Completa |
| Migraciones (10 entidades) | ✅ Completa |
| Modelos Eloquent | ✅ Completa |
| Servicios y Actions | ✅ Completa |
| Panel admin (Livewire) + Gestión de usuarios | ✅ Completa |
| Sitio web público (Blade) | ✅ Completa |
| Tests (Pest) — Fase 4 | ✅ Completa (121 tests) |

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
Fase 4 (Sitio Público)
           ↓
Fase 5 (Pulido + Producción)
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

- [x] `app/Services/MediaService.php`
  - `upload(UploadedFile, string $dir): Media`
  - `delete(Media): void`
  - `getUrl(Media): string`
- [x] `app/Jobs/OptimizeImage.php` (ShouldQueue, `$tries = 3`)
- [x] `app/Actions/UploadMedia.php`
- [x] `app/Http/Requests/UploadMediaRequest.php` (mensajes en español)
- [x] `app/Http/Resources/MediaResource.php`

### Verificación Fase 1
- [x] Feature test: subir imagen → Media creado + job despachado
- [x] Feature test: subir PDF → sin job de imagen
- [x] Unit test: `OptimizeImage` procesa fixture sin error

---

## Fase 2 — Backend de Contenido

**Objetivo:** Services, Actions y Policies para todos los módulos. Sin UI aún.

### Pages
- [x] `app/Services/PageService.php` (create, update, publish, archive)
- [x] `app/Actions/CreatePage.php`, `UpdatePage.php`, `PublishPage.php`
- [x] `app/Http/Requests/StorePageRequest.php`, `UpdatePageRequest.php`
- [x] `app/Policies/PagePolicy.php`

### Activities
- [x] `app/Services/ActivityService.php`
- [x] `app/Actions/CreateActivity.php`, `UpdateActivity.php`, `PublishActivity.php`, `SetActivityFeaturedImage.php`
- [x] `app/Http/Requests/StoreActivityRequest.php`, `UpdateActivityRequest.php`
- [x] `app/Policies/ActivityPolicy.php`

### Galleries
- [x] `app/Services/GalleryService.php` (create, update, addImage, removeImage, reorderImages)
- [x] `app/Actions/CreateGallery.php`, `AddGalleryImage.php`, `ReorderGalleryImages.php`, `RemoveGalleryImage.php`
- [x] `app/Http/Requests/StoreGalleryRequest.php`, `AddGalleryImageRequest.php`
- [x] `app/Policies/GalleryPolicy.php`

### Events
- [x] `app/Services/EventService.php`
- [x] `app/Actions/CreateEvent.php`, `UpdateEvent.php`
- [x] `app/Http/Requests/StoreEventRequest.php` (validar start_date ≤ end_date)
- [x] `app/Policies/EventPolicy.php`

### Documents
- [x] `app/Services/DocumentService.php`
- [x] `app/Actions/CreateDocument.php`, `UpdateDocument.php`
- [x] `app/Http/Requests/StoreDocumentRequest.php`
- [x] `app/Policies/DocumentPolicy.php`

### Auth
- [x] Registrar todas las Policies en `app/Providers/AuthServiceProvider.php`

### Verificación Fase 2
- [x] Unit tests Services: CRUD + transiciones de estado
- [x] Unit test: Policy deniega a editor en operaciones de admin
- [x] Unit test: `ActivityService::publish()` establece `published_at`
- [x] Unit test: `GalleryService::reorderImages()` actualiza posiciones

---

## Fase 3 — Panel de Administración ★ HITO

**Objetivo:** Panel Livewire completo para personal no técnico.

### Layout y auth
- [x] `resources/views/layouts/admin.blade.php` (sidebar Tailwind, nav en español)
- [x] `resources/views/auth/login.blade.php` ("Iniciar sesión")
- [x] `app/Http/Controllers/Admin/DashboardController.php`
- [x] `resources/views/admin/dashboard.blade.php` (conteos + actividades recientes)

### Livewire — Pages
- [x] `app/Livewire/Admin/PageTable.php` (búsqueda, paginación, filtro estado, eliminar)
- [x] `app/Livewire/Admin/PageForm.php` (crear/editar, slug auto, estado)
- [x] Vistas blade correspondientes

### Navegación de páginas
- [x] `database/migrations/add_navigation_fields_to_pages_table` — columnas `parent_id`, `show_in_header`, `show_in_footer`, `menu_order`
- [x] `app/Models/Page.php` — relaciones `parent()`/`children()`, scopes `inHeader()`/`inFooter()`, fillable y casts
- [x] `app/Services/PageService.php` — `Cache::forget('nav.header/footer')` en publish/update/archive/delete
- [x] `app/Http/Requests/StorePageRequest.php` — reglas + mensajes ES para 4 nuevos campos
- [x] `app/Http/Requests/UpdatePageRequest.php` — idem
- [x] `app/Livewire/Admin/PageForm.php` — sección "Navegación": página padre, orden, checkboxes encabezado/pie
- [x] `app/Livewire/Admin/PageTable.php` — eager-load `parent:id,title`
- [x] `resources/views/livewire/admin/page-table.blade.php` — columna "Menú" + indicador padre↳ en título
- [x] `database/factories/PageFactory.php` — estados `inHeader()` e `inFooter()`

### Livewire — Activities
- [x] `app/Livewire/Admin/ActivityTable.php` (búsqueda, filtro, publicar inline)
- [x] `app/Livewire/Admin/ActivityForm.php` (título, slug, excerpt, contenido, imagen, fecha)
- [x] Vistas blade correspondientes

### Livewire — Galleries
- [x] `app/Livewire/Admin/GalleryTable.php`
- [x] `app/Livewire/Admin/GalleryManager.php` (subir imágenes, reordenar con Alpine Sortable, eliminar)
- [x] Vista blade correspondiente

### Livewire — Events
- [x] `app/Livewire/Admin/EventTable.php`
- [x] `app/Livewire/Admin/EventForm.php` (fechas, ubicación, imagen)
- [x] Vistas blade correspondientes

### Livewire — Documents
- [x] `app/Livewire/Admin/DocumentTable.php` (filtro categoría/año)
- [x] `app/Livewire/Admin/DocumentUploader.php` (categoría, año, subir PDF)
- [x] Vistas blade correspondientes

### Configuración del sitio
- [x] `database/migrations/create_site_settings_table` — tabla singleton (22 columnas: org, contacto, redes, correo, donaciones)
- [x] `app/Models/SiteSetting.php` — `static instance()` con `firstOrCreate`
- [x] `app/Services/SettingService.php` — `get()` y `update()`
- [x] `database/seeders/SiteSettingSeeder.php` — datos iniciales de la fundación
- [x] `app/Livewire/Admin/SettingsForm.php` — 5 secciones, `dispatch('notify')` sin redirect
- [x] `resources/views/livewire/admin/settings-form.blade.php`
- [x] `resources/views/admin/settings/index.blade.php`
- [x] Ruta `GET /admin/settings` → `admin.settings`
- [x] Sidebar: ítem "Configuración" con ícono engranaje
- [x] `database/migrations/add_donation_digital_to_site_settings_table` — `donation_nequi`, `donation_daviplata`, `donation_qr_media_id` (FK → media)
- [x] `app/Models/SiteSetting.php` — relación `donationQr()` → Media
- [x] `app/Livewire/Admin/SettingsForm.php` — `WithFileUploads`, upload QR vía `MediaService`, campos Nequi/Daviplata, `removeQr()`
- [x] `resources/views/livewire/admin/settings-form.blade.php` — sección donaciones expandida: transferencia bancaria, pagos digitales (Nequi/Daviplata), zona upload QR con thumbnail y preview

### Infraestructura de correo de contacto
- [x] `app/Mail/ContactFormMail.php` — Envelope/Content API, `From:` construido desde settings
- [x] `app/Jobs/SendContactEmail.php` — `ShouldQueue`, `$tries = 3`, valores de settings capturados al despachar
- [x] `resources/views/emails/contact-form.blade.php` — plantilla en español

### Control de acceso por roles (Admin / Editor)
- [x] `app/Http/Middleware/PanelMiddleware.php` — admite Admin **o** Editor; permite acceso al panel de contenido
- [x] `app/Http/Kernel.php` — alias `'panel'` registrado junto a `'admin'` (solo Admin)
- [x] `routes/web.php` — rutas de contenido bajo `panel`, rutas admin-exclusivas bajo `admin`
- [x] Todas las políticas de contenido (`PagePolicy`, `ActivityPolicy`, `GalleryPolicy`, `EventPolicy`, `DocumentPolicy`) — publish/archive/delete abiertos a ambos roles (`return true`)
- [x] `app/Livewire/Admin/SettingsForm.php` — guard `abort_if` en `save()` y `removeQr()` (defensa en profundidad)
- [x] `resources/views/layouts/admin.blade.php` — "Usuarios" y "Configuración" visibles solo para Admin (`@if role === Admin`)
- [x] `app/Enums/UserRole.php` — método `label(): string` añadido (`'Administrador'` / `'Editor'`)

### Gestión de usuarios
- [x] `app/Policies/UserPolicy.php` — solo Admin; `delete()` impide auto-eliminación
- [x] Registrar `UserPolicy` en `app/Providers/AuthServiceProvider.php`
- [x] `app/Http/Requests/StoreUserRequest.php` — nombre, correo (único), rol (enum), contraseña (min 8, confirmada); mensajes en español
- [x] `app/Http/Requests/UpdateUserRequest.php` — igual pero contraseña nullable; unique ignora usuario actual
- [x] `app/Actions/CreateUser.php` — crea usuario con `Hash::make()` explícito
- [x] `app/Actions/UpdateUser.php` — actualiza; omite contraseña si vacía
- [x] `app/Services/UserService.php` — `create()`, `update()`, `delete()`
- [x] `app/Livewire/Admin/UserTable.php` — lista con búsqueda, paginación, eliminar (con guard de auto-eliminación)
- [x] `app/Livewire/Admin/UserForm.php` — crear/editar; `authorize()` en `mount()` y `save()`; contraseña opcional en edición
- [x] `resources/views/livewire/admin/user-table.blade.php` — tabla con badge de rol, indicador "(tú)", acciones
- [x] `resources/views/livewire/admin/user-form.blade.php` — formulario con validación en español
- [x] `resources/views/admin/users/{index,create,edit}.blade.php`
- [x] `database/seeders/UserSeeder.php` — `admin@hogarnazareth.org` (Admin) y `editor@hogarnazareth.org` (Editor) vía `firstOrCreate`

### Rutas admin
- [x] `/admin/dashboard`
- [x] `/admin/pages` (index, create, edit)
- [x] `/admin/activities` (index, create, edit)
- [x] `/admin/galleries` (index, create, manage)
- [x] `/admin/events` (index, create, edit)
- [x] `/admin/documents` (index, create)
- [x] `/admin/settings` (solo Admin)
- [x] `/admin/users` (index, create, edit) — solo Admin

### Verificación Fase 3
- [x] Feature test: `ActivityForm` crea registro vía `ActivityService`
- [x] Feature test: `GalleryManager` sube imagen y crea `GalleryImage`
- [x] Feature test: rutas admin sin auth → redirige login
- [x] Feature test: editor puede acceder a rutas de contenido, bloqueado en `/admin/settings` y `/admin/users`
- [x] Feature test: `UserForm` crea usuario (admin) y rechaza a editor (403)
- [x] Feature test: `UserTable` elimina usuario; impide auto-eliminación
- [x] Feature test: validaciones de usuario — correo único, contraseñas no coinciden, contraseña opcional en edición
- [ ] **Manual:** staff puede crear y publicar todos los tipos de contenido

---

## Fase 4 — Sitio Web Público

**Objetivo:** Exposición pública del contenido gestionado.

### Infraestructura de navegación (prerequisito)
- [x] `app/Services/NavigationService.php` — `headerPages()` y `footerPages()` con caché 5 min
- [x] `app/Http/View/Composers/NavigationComposer.php` — inyecta `$navHeaderPages` y `$navFooterPages`
- [x] Registrar `NavigationComposer` en `app/Providers/AppServiceProvider.php` para `layouts.public`

### Infraestructura de configuración del sitio (prerequisito)
- [x] `app/Http/View/Composers/SettingsComposer.php` — llama `SiteSetting::instance()` e inyecta `$siteSettings` en `layouts.public`
- [x] Registrar `SettingsComposer` en `AppServiceProvider` junto con `NavigationComposer` — ambos sobre `layouts.public`

### Layout
- [x] `resources/views/layouts/public.blade.php` (header nav español, footer, hamburger Alpine)

### Controladores y vistas
- [x] `Website/HomeController` → `/` (hero + últimas actividades + próximos eventos)
- [x] `Website/ActivityController` → `/actividades`, `/actividades/{slug}`
- [x] `Website/GalleryController` → `/galerias`, `/galerias/{slug}` (lightbox Alpine)
- [x] `Website/EventController` → `/eventos`, `/eventos/{slug}`
- [x] `Website/DocumentController` → `/transparencia` (agrupado por año y categoría)
- [x] `Website/PageController` → `/paginas/{slug}` — usar `scopePublished()->firstOrFail()` (no route model binding)
- [x] `resources/views/website/pages/show.blade.php` — breadcrumb automático si tiene padre
- [x] `Website/DonationsController` → `GET /donaciones`
- [x] `resources/views/website/donations.blade.php`
- [x] `Website/ContactController` → `GET /contacto`
- [x] `app/Livewire/Website/ContactForm.php`
- [x] `resources/views/website/contact.blade.php`

### Rutas públicas
- [x] Grupo `Route::name('website.')` con constraint `where('slug', '[a-z0-9-]+')` en rutas de slug
- [x] `GET /donaciones` → `DonationsController` → `website.donations`
- [x] `GET /contacto` → `ContactController` → `website.contact`

### SEO básico
- [x] `@section('meta_title')`, `@section('meta_description')` por vista
- [x] Open Graph tags en actividades, galerías y páginas; Facebook y Twitter metatags; canonical

### Verificación Fase 4
- [x] Feature test: `GET /actividades` → solo publicadas
- [x] Feature test: `GET /actividades/{slug}` draft → 404
- [x] Feature test: `GET /paginas/{slug}` draft → 404
- [x] Feature test: página con padre muestra breadcrumb
- [x] Feature test: galería sin N+1
- [x] Feature test: `GET /contacto` → renderiza formulario cuando `mail_contact_to` configurado
- [x] Feature test: `GET /contacto` → muestra aviso cuando `mail_contact_to` es null
- [x] Feature test: `ContactForm::submit()` con honeypot relleno → no despacha `SendContactEmail`
- [x] Feature test: `ContactForm::submit()` válido → despacha `SendContactEmail` con datos correctos
- [x] Feature test: `GET /donaciones` → muestra datos bancarios si configurados; muestra fallback si todos son null
- [x] Feature test: `GET /donaciones` → muestra QR si `donation_qr_media_id` configurado
- [x] Feature test: `GET /donaciones` → muestra sección Nequi si `donation_nequi` configurado
- [x] Unit test: `NavigationService::headerPages()` filtra solo publicadas con `show_in_header=true`
- [x] Unit test: resultado de nav está en caché (segunda llamada no toca BD)
- [x] Unit test: `SettingsComposer` inyecta instancia de `SiteSetting` en la vista

---

## Fase 5 — Pulido y Producción

**Objetivo:** Calidad, rendimiento, seguridad, accesibilidad.

### Seeders (contenido en español)
- [ ] `UserSeeder` (2 admin)

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

---

## Archivos de Referencia Críticos

- [domain-model.md](domain-model.md) — Fuente de verdad para migraciones y relaciones
- [laravel-architecture-guide.md](laravel-architecture-guide.md) — Patrones: Model, Livewire, Service
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
