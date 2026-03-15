<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Services\GalleryService;
use App\Services\MediaService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for managing a single gallery's details and images.
 *
 * Handles detail editing (title, slug, description), image uploads,
 * image removal, and image reordering via GalleryService and MediaService.
 */
final class GalleryManager extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    #[Locked]
    public int $galleryId;

    public string $title = '';

    public string $slug = '';

    public string $description = '';

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $imageUpload = null;

    public ?string $imagePreviewUrl = null;

    public string $newCaption = '';

    private GalleryService $galleryService;

    private MediaService $mediaService;

    /**
     * Resolve services via Livewire boot — constructor injection is not supported by ComponentRegistry.
     */
    public function boot(GalleryService $galleryService, MediaService $mediaService): void
    {
        $this->galleryService = $galleryService;
        $this->mediaService   = $mediaService;
    }

    /**
     * Populate form fields from the mounted Gallery model.
     */
    public function mount(Gallery $gallery): void
    {
        $this->galleryId   = $gallery->id;
        $this->title       = $gallery->title;
        $this->slug        = $gallery->slug;
        $this->description = $gallery->description ?? '';
    }

    /**
     * Auto-update slug whenever the title changes.
     */
    public function updatedTitle(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    /**
     * Set the image preview URL when a file is selected.
     */
    public function updatedImageUpload(): void
    {
        if ($this->imageUpload) {
            $this->imagePreviewUrl = $this->imageUpload->temporaryUrl();
        }
    }

    /**
     * Save the gallery title, slug, and description.
     */
    public function saveDetails(): void
    {
        $this->validate($this->detailRules());

        $gallery = $this->gallery();
        $this->authorize('update', $gallery);

        $this->galleryService->update($gallery, [
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description ?: null,
        ]);

        session()->flash('success', 'Galería actualizada.');
    }

    /**
     * Upload a new image and attach it to the gallery.
     */
    public function uploadImage(): void
    {
        $this->validate([
            'imageUpload' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $gallery = $this->gallery();
        $this->authorize('update', $gallery);

        $media = $this->mediaService->upload($this->imageUpload, 'galleries');

        $this->galleryService->addImage($gallery, $media, $this->newCaption ?: null);

        $this->imageUpload      = null;
        $this->imagePreviewUrl  = null;
        $this->newCaption       = '';

        session()->flash('success', 'Imagen añadida.');
    }

    /**
     * Remove an image from the gallery.
     */
    public function removeImage(int $galleryImageId): void
    {
        $gallery      = $this->gallery();
        $galleryImage = GalleryImage::findOrFail($galleryImageId);

        $this->authorize('update', $gallery);

        $this->galleryService->removeImage($galleryImage);

        session()->flash('success', 'Imagen eliminada.');
    }

    /**
     * Reorder gallery images given an ordered array of GalleryImage IDs.
     *
     * Called from Alpine.js sortable via $wire.reorder(ids).
     *
     * @param  array<int>  $orderedIds
     */
    public function reorder(array $orderedIds): void
    {
        $gallery = $this->gallery();
        $this->authorize('update', $gallery);

        $this->galleryService->reorderImages($gallery, $orderedIds);
    }

    public function render(): View
    {
        return view('livewire.admin.gallery-manager', [
            'gallery' => $this->gallery(),
        ]);
    }

    /**
     * Fetch the gallery with its images and their media, fresh from DB.
     */
    private function gallery(): Gallery
    {
        return Gallery::with('images.media')->findOrFail($this->galleryId);
    }

    /**
     * @return array<string, mixed>
     */
    private function detailRules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('galleries', 'slug')->ignore($this->galleryId),
            ],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
