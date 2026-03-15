<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\ContentStatus;
use App\Models\Activity;
use App\Models\Media;
use App\Services\ActivityService;
use App\Services\MediaService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for creating and editing admin Activities.
 *
 * Handles auto-slug generation, validation, image upload,
 * draft saving, and publishing via ActivityService and MediaService.
 */
final class ActivityForm extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    #[Locked]
    public ?int $activityId = null;

    public string $title = '';

    public string $slug = '';

    public string $excerpt = '';

    public string $content = '';

    public string $status = 'draft';

    public bool $showMediaBrowser = false;

    /** @var array<int, array{id: int, url: string, alt: string}> */
    public array $mediaItems = [];

    public ?int $featuredImageId = null;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $imageUpload = null;

    public ?string $imagePreviewUrl = null;

    public ?string $existingImageUrl = null;

    private ActivityService $activityService;

    private MediaService $mediaService;

    /**
     * Resolve services via Livewire boot — constructor injection is not supported by ComponentRegistry.
     */
    public function boot(ActivityService $activityService, MediaService $mediaService): void
    {
        $this->activityService = $activityService;
        $this->mediaService    = $mediaService;
    }

    /**
     * Populate form fields when editing an existing activity.
     */
    public function mount(?Activity $activity = null): void
    {
        if ($activity && $activity->exists) {
            $this->activityId     = $activity->id;
            $this->title          = $activity->title;
            $this->slug           = $activity->slug;
            $this->excerpt        = $activity->excerpt ?? '';
            $this->content        = $activity->content;
            $this->status         = $activity->status->value;
            $this->featuredImageId = $activity->featured_image_id;

            if ($activity->featuredImage) {
                $this->existingImageUrl = Storage::disk('public')->url(
                    $activity->featuredImage->file_path
                );
            }
        }
    }

    /**
     * Auto-generate the slug from the title on create only.
     */
    public function updatedTitle(string $value): void
    {
        if (! $this->activityId) {
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
        $this->imageUpload      = null;
        $this->imagePreviewUrl  = null;
    }

    /**
     * Save as draft (create or update) and redirect to index.
     */
    public function save(): void
    {
        $this->validate($this->rules());

        if ($this->activityId) {
            $this->authorize('update', Activity::findOrFail($this->activityId));
        } else {
            $this->authorize('create', Activity::class);
        }

        $activity = $this->persistActivity();

        $this->handleImageUpload($activity);

        session()->flash('success', 'Actividad guardada.');

        $this->redirect(route('admin.activities.index'), navigate: false);
    }

    /**
     * Publish the activity after saving and redirect to index.
     */
    public function publish(): void
    {
        $this->validate($this->rules());

        if ($this->activityId) {
            $this->authorize('update', Activity::findOrFail($this->activityId));
        } else {
            $this->authorize('create', Activity::class);
        }

        $activity = $this->persistActivity();

        $this->handleImageUpload($activity);

        $this->activityService->publish($activity);

        session()->flash('success', 'Actividad publicada.');

        $this->redirect(route('admin.activities.index'), navigate: false);
    }

    /**
     * Accept a base64 image from the content editor, store via MediaService, and return its URL.
     *
     * @return array{url: string, alt: string}|array<never, never>
     */
    #[Renderless]
    public function uploadEditorImage(string $imageDataUrl): array
    {
        if (! preg_match('/^data:(?P<mime>image\/\w+);base64,(?P<data>.+)$/', $imageDataUrl, $matches)) {
            return [];
        }

        $mimeType  = $matches['mime'];
        $extension = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            default      => 'jpg',
        };

        $tmpPath = tempnam(sys_get_temp_dir(), 'editor_') . '.' . $extension;
        file_put_contents($tmpPath, base64_decode($matches['data']));

        $uploadedFile = new UploadedFile($tmpPath, 'editor-image.' . $extension, $mimeType, null, true);
        $media        = $this->mediaService->upload($uploadedFile, 'activities');

        @unlink($tmpPath);

        return [
            'url' => $this->mediaService->getUrl($media),
            'alt' => $media->alt_text ?? '',
        ];
    }

    /**
     * Load the latest images from the media library and show the browser panel.
     */
    public function loadMediaLibrary(): void
    {
        $this->mediaItems = Media::where('mime_type', 'like', 'image/%')
            ->latest()
            ->limit(40)
            ->get()
            ->map(fn (Media $m) => [
                'id'  => $m->id,
                'url' => $this->mediaService->getUrl($m),
                'alt' => $m->alt_text ?? '',
            ])
            ->toArray();

        $this->showMediaBrowser = true;
    }

    public function render(): View
    {
        return view('livewire.admin.activity-form');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        $uniqueSlug = Rule::unique('activities', 'slug');

        if ($this->activityId) {
            $uniqueSlug = $uniqueSlug->ignore($this->activityId);
        }

        return [
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', $uniqueSlug],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'status'      => ['required', Rule::enum(ContentStatus::class)],
            'imageUpload' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    /**
     * Create or update the activity record via ActivityService.
     */
    private function persistActivity(): Activity
    {
        $data = [
            'title'   => $this->title,
            'slug'    => $this->slug,
            'excerpt' => $this->excerpt ?: null,
            'content' => $this->content,
            'status'  => $this->status,
        ];

        if ($this->activityId) {
            $activity = Activity::findOrFail($this->activityId);

            return $this->activityService->update($activity, $data);
        }

        $activity = $this->activityService->create($data);
        $this->activityId = $activity->id;

        return $activity;
    }

    /**
     * Upload and attach the featured image if one was staged.
     */
    private function handleImageUpload(Activity $activity): void
    {
        if ($this->imageUpload) {
            $media = $this->mediaService->upload($this->imageUpload, 'activities');
            $this->activityService->setFeaturedImage($activity, $media);
        }
    }
}
