
# Laravel Architecture Guide
Hogar Nazareth Web Platform

This document defines the **development architecture, conventions, and implementation rules** for the Laravel application.

It combines:

- project architecture
- Laravel development best practices
- Eloquent patterns
- Livewire patterns
- Queue system design
- API design
- coding rules for Copilot

The goal is to ensure **consistent, scalable, and maintainable Laravel code**.

---

# 1. Technology Stack

The system is built using:

Laravel 10+  
PHP 8.2+  
MySQL  
Database queues
Laravel scheduler 
Sanctum (API authentication)  
Livewire (admin interactivity)

Testing:

Pest / PHPUnit

---

# 2. Development Workflow

Every feature implementation follows this workflow.

1. Analyse requirements
2. Design database schema
3. Implement Eloquent models
4. Build services and actions
5. Implement controllers
6. Implement Livewire components (if needed)
7. Add queued jobs for heavy tasks
8. Write tests
9. Validate implementation

Verification commands:

php artisan migrate:status
php artisan route:list
php artisan queue:work --once
php artisan test

---

# 3. Laravel Project Structure

The project uses the following structure.

app
 ├── Actions
 ├── Console
 ├── Enums
 ├── Http
 │   ├── Controllers
 │   │   ├── Admin
 │   │   └── Website
 │   ├── Requests
 │   └── Resources
 ├── Jobs
 ├── Livewire
 ├── Models
 ├── Policies
 ├── Services
 ├── Support
 └── Traits

---

# 4. Core Principles

Controllers must remain thin.

Business logic must live in:

Services  
Actions  
Jobs

Validation must be handled using:

Form Requests

Authorization must be handled using:

Policies

Long running tasks must be executed using:

Queues

---

# 5. Models

All database entities use Eloquent models.

Examples for this project:

Page  
Activity  
Gallery  
GalleryImage  
Event  
Document  
Media  
User

Models should contain:

- relationships
- scopes
- attribute casting
- small domain logic

Heavy operations should be placed in services.

---

# 6. Eloquent Rules

### Must

- Use eager loading
- Use typed return types
- Use enums for statuses
- Use scopes for filters

### Avoid

- N+1 queries
- raw SQL when unnecessary
- heavy logic inside models

---

# Example Model

final class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'featured_image_id'
    ];

    protected $casts = [
        'status' => ContentStatus::class,
        'published_at' => 'immutable_datetime'
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ContentStatus::Published);
    }
}

---

# 7. Services

Services handle business logic.

Location:

app/Services

Examples:

PageService  
ActivityService  
GalleryService  
EventService  
DocumentService  
MediaService  

Example responsibilities:

ActivityService

- create activity
- update activity
- publish activity

GalleryService

- create gallery
- upload images
- reorder images

---

# 8. Actions

Actions represent **single operations**.

Examples:

CreateActivity  
UpdateActivity  
PublishActivity  
UploadMedia  
AttachMedia  
AddGalleryImage  

Each action should have **one responsibility**.

---

# 9. Livewire Components

Livewire is used for **admin interactivity**.

Location:

app/Livewire

Examples:

ActivityTable  
GalleryManager  
EventForm  
DocumentUploader  

Example component:

class ActivityTable extends Component
{
    public string $search = '';

    public function render()
    {
        return view('livewire.activity-table', [
            'activities' => Activity::query()
                ->when($this->search,
                    fn($q) => $q->where('title','like',"%{$this->search}%")
                )
                ->paginate(10)
        ]);
    }
}

---

# 10. Queues

Queues are used for background processing tasks.

Examples:

- image optimization
- email sending
- media processing
- document processing

Location:

app/Jobs

Example job:

```php
class OptimizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public Media $media
    ) {}

    public function handle(): void
    {
        // image optimization logic
    }
}

---

# 11. API Design

API endpoints must follow REST standards.

Example routes:

GET /api/v1/activities  
GET /api/v1/activities/{activity}

POST /api/v1/activities  
PUT /api/v1/activities/{activity}  
DELETE /api/v1/activities/{activity}

Use API Resources.

Example:

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'published_at' => $this->published_at,
        ];
    }
}

---

# 12. Media Handling

Media files are central to the system.

Supported files:

images  
documents

Media entity stores:

file_path  
mime_type  
alt_text  
size

MediaService responsibilities:

upload  
optimize  
attach to models

---

# 13. Performance Rules

Always eager load relationships.

Example:

Activity::with('featuredImage')->get();

Use:

- pagination
- caching
- chunking

Avoid loading large datasets.

---

# 14. Security Rules

Never trust user input.

Always:

- validate requests
- use CSRF protection
- escape Blade output
- encrypt sensitive data

---

# 15. Coding Standards

Follow:

PSR-12

Rules:

- strict types
- typed properties
- dependency injection
- no business logic in controllers