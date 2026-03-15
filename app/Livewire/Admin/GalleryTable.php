<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for the admin galleries listing table.
 *
 * Provides search, pagination, and delete confirmation for Gallery records.
 */
final class GalleryTable extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /** @var array<string> */
    protected $queryString = ['search'];

    public string $search = '';

    #[Locked]
    public ?int $deleteId = null;

    public function __construct(
        private readonly GalleryService $galleryService,
    ) {}

    /**
     * Reset pagination when search changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Set the gallery ID pending deletion confirmation.
     */
    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    /**
     * Cancel the pending deletion.
     */
    public function cancelDelete(): void
    {
        $this->deleteId = null;
    }

    /**
     * Permanently delete the gallery after confirmation.
     */
    public function deleteGallery(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        $gallery = Gallery::find($this->deleteId);

        if ($gallery) {
            $this->authorize('delete', $gallery);
            $this->galleryService->delete($gallery);
        }

        $this->deleteId = null;

        session()->flash('success', 'Galería eliminada.');
    }

    public function render(): View
    {
        $galleries = Gallery::query()
            ->withCount('images')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.gallery-table', ['galleries' => $galleries]);
    }
}
