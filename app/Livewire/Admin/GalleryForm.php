<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * Livewire component for creating a new Gallery.
 *
 * Handles auto-slug generation, validation, and creation via GalleryService.
 * After creation, redirects to the gallery manager.
 */
final class GalleryForm extends Component
{
    use AuthorizesRequests;

    public string $title = '';

    public string $slug = '';

    public string $description = '';

    private GalleryService $galleryService;

    /**
     * Resolve services via Livewire boot — constructor injection is not supported by ComponentRegistry.
     */
    public function boot(GalleryService $galleryService): void
    {
        $this->galleryService = $galleryService;
    }

    /**
     * Auto-generate the slug from the title.
     */
    public function updatedTitle(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    /**
     * Create the gallery and redirect to its manager page.
     */
    public function save(): void
    {
        $this->validate($this->rules());

        $this->authorize('create', Gallery::class);

        $gallery = $this->galleryService->create([
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description ?: null,
        ]);

        session()->flash('success', 'Galería creada.');

        $this->redirect(route('admin.galleries.manage', $gallery), navigate: false);
    }

    public function render(): View
    {
        return view('livewire.admin.gallery-form');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', Rule::unique('galleries', 'slug')],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
