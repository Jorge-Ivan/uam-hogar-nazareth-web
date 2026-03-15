<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Services\PageService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for the admin pages listing table.
 *
 * Provides search, status filtering, pagination, and
 * soft-delete confirmation for Page records.
 */
final class PageTable extends Component
{
    use WithPagination;

    /** @var array<string> */
    protected $queryString = ['search', 'statusFilter'];

    public string $search = '';

    public string $statusFilter = '';

    public ?int $deleteId = null;

    public function __construct(
        private readonly PageService $pageService,
    ) {}

    /**
     * Reset pagination when search changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when status filter changes.
     */
    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Set the page ID pending deletion confirmation.
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
     * Permanently delete the page after confirmation.
     */
    public function deletePage(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        $page = Page::find($this->deleteId);

        if ($page) {
            $page->delete();
        }

        $this->deleteId = null;

        $this->dispatch('notify', message: 'Página eliminada.');
    }

    public function render(): View
    {
        $pages = Page::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.page-table', ['pages' => $pages]);
    }
}
