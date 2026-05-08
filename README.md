# Hogar Nazareth — Plataforma Web

Plataforma web dinámica para la **Fundación Hogar del Anciano Nazareth**, desarrollada como proyecto de práctica social universitaria.

Permite al personal de la fundación gestionar contenido institucional (actividades, galerías, eventos, documentos de transparencia) sin necesidad de conocimientos técnicos.

- **Sitio actual de la fundación:** https://fundaciondelancianonazareth.com/
- **Repositorio:** https://github.com/Jorge-Ivan/uam-hogar-nazareth-web

---

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Backend | Laravel 10 / PHP 8.2 |
| Base de datos | MySQL |
| Frontend admin | Livewire 3 + Tailwind CSS |
| Frontend público | Blade + Alpine.js |
| Colas | Database queues + Laravel Scheduler |
| Testing | Pest 3 (124 tests) |
| Entorno local | Laravel Herd |

---

## Requisitos

- PHP 8.2+
- Composer 2+
- MySQL 8+
- Node.js 18+
- [Laravel Herd](https://herd.laravel.com/) (recomendado en macOS) o cualquier servidor compatible

---

## Instalación local

```bash
# 1. Clonar el repositorio
git clone https://github.com/Jorge-Ivan/uam-hogar-nazareth-web.git
cd uam-hogar-nazareth-web

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install

# 4. Configurar variables de entorno
cp .env.example .env
php artisan key:generate

# 5. Editar .env con tus credenciales de MySQL:
#   DB_DATABASE=hogarnazareth
#   DB_USERNAME=root
#   DB_PASSWORD=tu_password
#   QUEUE_CONNECTION=database
#   APP_LOCALE=es

# 6. Crear la base de datos
mysql -u root -p -e "CREATE DATABASE hogarnazareth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 7. Ejecutar migraciones y seeders
php artisan migrate
php artisan db:seed

# 8. Enlazar almacenamiento
php artisan storage:link

# 9. Compilar assets
npm run build
```

---

## Comandos útiles

```bash
# Servidor de desarrollo
php artisan serve

# Compilar assets en modo watch
npm run dev

# Correr tests
php artisan test

# Ver estado de migraciones
php artisan migrate:status

# Ver rutas registradas
php artisan route:list

# Procesar una tarea de la cola
php artisan queue:work --once

# Limpiar caché
php artisan optimize:clear
```

---

## Estructura del proyecto

```
app/
├── Actions/        # Operaciones de responsabilidad única
├── Enums/          # ContentStatus, UserRole
├── Http/
│   ├── Controllers/
│   │   ├── Admin/      # Panel de administración
│   │   └── Website/    # Sitio público
│   ├── Requests/   # Validación de formularios
│   ├── Resources/  # API Resources (JSON)
│   └── View/
│       └── Composers/  # NavigationComposer, SettingsComposer
├── Jobs/           # Tareas en segundo plano (OptimizeImage, SendContactEmail)
├── Livewire/
│   ├── Admin/      # Componentes interactivos del panel
│   └── Website/    # Componentes interactivos del sitio público
├── Mail/           # Mailables (ContactFormMail)
├── Models/         # Modelos Eloquent
├── Policies/       # Autorización por modelo
└── Services/       # Lógica de negocio

docs/               # Documentación del proyecto
├── architecture.md                # Arquitectura del sistema
├── design-guide.md                # Paleta de colores, tipografía y patrones UI
├── domain-model.md                # Entidades y relaciones
├── laravel-architecture-guide.md  # Patrones y convenciones
├── plan.md                        # Hoja de ruta (estado actual)
└── project-context.md             # Contexto organizacional
```

---

## Módulos del sistema

| Módulo | Descripción |
|---|---|
| **Páginas** | Contenido institucional con soporte de subpáginas, orden en menú y visibilidad en header/footer |
| **Actividades** | Publicaciones de actividades con imagen destacada y estado de publicación |
| **Galerías** | Colecciones de fotos con reordenamiento drag & drop |
| **Eventos** | Eventos con fechas, ubicación e imagen |
| **Documentos** | Transparencia institucional agrupada por año y categoría |
| **Media** | Gestión centralizada de imágenes y archivos PDF |
| **Configuración** | Datos del sitio: contacto, redes sociales, correo y donaciones (panel de admin) |
| **Usuarios** | Gestión de cuentas con roles Admin y Editor (solo administradores) |

---

## Roles de usuario

| Rol | Permisos |
|---|---|
| `admin` | Acceso completo al sistema |
| `editor` | Gestión de contenido, sin configuración del sistema |

---

## Flujo de publicación

```
Borrador → Publicado → Archivado
```

Los editores crean borradores, los revisan y los publican cuando están listos. El contenido archivado no se elimina.

---

## Convenciones del código

- `declare(strict_types=1)` en todos los archivos PHP
- Lógica de negocio en `Services/` y `Actions/`, nunca en Controllers
- Toda subida de archivos pasa por `MediaService`
- Optimización de imágenes vía job en cola (`OptimizeImage`)
- UI del admin y mensajes de error **en español**
- Nombres de variables, clases y comentarios **en inglés**

---

## Estado del proyecto

| Fase | Descripción | Estado |
|---|---|---|
| Fase 0 | Fundación: Laravel, migraciones, modelos | ✅ Completa |
| Fase 1 | Infraestructura de media | ✅ Completa |
| Fase 2 | Backend: Services, Actions, Policies | ✅ Completa |
| Fase 3 | Panel de administración (Livewire) | ✅ Completa |
| Fase 4 | Sitio web público | ✅ Completa |
| Fase 5 | Pulido y producción | ✅ Completa |

Ver [docs/plan.md](docs/plan.md) para la hoja de ruta completa con detalle por fases.

---

## Testing y Calidad

**124 tests automatizados** cubren:
- Autenticación y autorización
- Validación de formularios
- Operaciones CRUD en todos los módulos
- Caché y rendimiento
- Envío de correos
- Integración con reCAPTCHA

```bash
# Ejecutar suite de tests
php artisan test

# Ejecutar un test específico
php artisan test tests/Feature/Admin/ActivityFormTest.php

# Ver cobertura de código
php artisan test --coverage
```

**Optimizaciones implementadas:**
- Cache en controllers públicos (TTL 5 min) — Home y Activity index
- Cache en SiteSetting::instance() (TTL 1 hora)
- Eager loading en todas las queries — sin N+1
- Páginas de error en español (404, 403, 500)
- Scheduler para limpieza de jobs fallidos
- Mensajes de validación y autenticación en español

---

## Licencia

Este proyecto está distribuido bajo la [Licencia MIT](LICENSE).

```
Copyright (c) 2026 Jorge Ivan Carrillo Gonzalez
Universidad Autónoma de Manizales — Práctica Social
```

Se permite el uso, copia, modificación y distribución del software con la condición de conservar el aviso de copyright en todas las copias.

---

## Contexto académico

Proyecto desarrollado por **[Jorge Carrillo](https://www.linkedin.com/in/jorgecarrillog/)** como **práctica social universitaria** en la **[Universidad Autónoma de Manizales (UAM)](https://www.autonoma.edu.co/)**.

El objetivo es modernizar la presencia digital de la Fundación Hogar del Anciano Nazareth y facilitar la autogestión de contenido por parte del personal no técnico de la fundación.
