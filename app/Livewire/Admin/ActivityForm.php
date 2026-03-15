<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\ContentStatus;
use App\Models\Activity;
use App\Services\ActivityService;
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
