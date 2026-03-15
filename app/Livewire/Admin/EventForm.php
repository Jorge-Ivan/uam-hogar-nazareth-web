<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Services\EventService;
use App\Services\MediaService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for creating and editing admin Events.
 *
 * Handles auto-slug generation, validation, date fields, location,
 * and image upload via EventService and MediaService.
 */
final class EventForm extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    #[Locked]
    public ?int $eventId = null;

    public string $title = '';

    public string $slug = '';

    public string $description = '';

    public string $startDate = '';

    public string $endDate = '';

    public string $location = '';

    public ?int $featuredImageId = null;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $imageUpload = null;

    public ?string $imagePreviewUrl = null;

    public ?string $existingImageUrl = null;

    public function __construct(
        private readonly EventService $eventService,
        private readonly MediaService $mediaService,
    ) {}

    /**
     * Populate form fields when editing an existing event.
     */
    public function mount(?Event $event = null): void
    {
        if ($event && $event->exists) {
            $this->eventId        = $event->id;
            $this->title          = $event->title;
            $this->slug           = $event->slug;
            $this->description    = $event->description ?? '';
            $this->startDate      = $event->start_date->format('Y-m-d');
            $this->endDate        = $event->end_date?->format('Y-m-d') ?? '';
            $this->location       = $event->location ?? '';
            $this->featuredImageId = $event->featured_image_id;

            if ($event->featuredImage) {
                $this->existingImageUrl = Storage::disk('public')->url(
                    $event->featuredImage->file_path
                );
            }
        }
    }

    /**
     * Auto-generate the slug from the title on create only.
     */
    public function updatedTitle(string $value): void
    {
        if (! $this->eventId) {
            $this->slug = Str::slug($value);
        }
    }

    /**
     * Set the preview URL when a new image is selected.
     */
    public function updatedImageUpload(): void
    {
        if ($this->imageUpload) {
            $this->imagePreviewUrl = $this->imageUpload->temporaryUrl();
        }
    }

    /**
     * Clear the staged image upload without saving.
     */
    public function removeImage(): void
    {
        $this->imageUpload     = null;
        $this->imagePreviewUrl = null;
    }

    /**
     * Save the event and redirect to the events index.
     */
    public function save(): void
    {
        $this->validate($this->rules());

        if ($this->eventId) {
            $this->authorize('update', Event::findOrFail($this->eventId));
        } else {
            $this->authorize('create', Event::class);
        }

        $event = $this->persistEvent();

        $this->handleImageUpload($event);

        session()->flash('success', 'Evento guardado.');

        $this->redirect(route('admin.events.index'), navigate: false);
    }

    public function render(): View
    {
        return view('livewire.admin.event-form');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        $uniqueSlug = Rule::unique('events', 'slug');

        if ($this->eventId) {
            $uniqueSlug = $uniqueSlug->ignore($this->eventId);
        }

        return [
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', $uniqueSlug],
            'description' => ['nullable', 'string'],
            'startDate'   => ['required', 'date'],
            'endDate'     => ['nullable', 'date', 'after_or_equal:startDate'],
            'location'    => ['nullable', 'string', 'max:255'],
            'imageUpload' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    /**
     * Create or update the event record via EventService.
     */
    private function persistEvent(): Event
    {
        $data = [
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description ?: null,
            'start_date'  => $this->startDate,
            'end_date'    => $this->endDate ?: null,
            'location'    => $this->location ?: null,
        ];

        if ($this->eventId) {
            $event = Event::findOrFail($this->eventId);

            return $this->eventService->update($event, $data);
        }

        $event = $this->eventService->create($data);
        $this->eventId = $event->id;

        return $event;
    }

    /**
     * Upload and attach the featured image if one was staged.
     */
    private function handleImageUpload(Event $event): void
    {
        if ($this->imageUpload) {
            $media = $this->mediaService->upload($this->imageUpload, 'events');
            $this->eventService->update($event, ['featured_image_id' => $media->id]);
        }
    }
}
