<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentYear;
use App\Services\DocumentService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for the admin documents listing table.
 *
 * Provides category and year filtering, pagination, and
 * delete confirmation for Document records.
 */
final class DocumentTable extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /** @var array<string> */
    protected $queryString = ['categoryFilter', 'yearFilter'];

    public string $categoryFilter = '';

    public string $yearFilter = '';

    #[Locked]
    public ?int $deleteId = null;

    public function __construct(
        private readonly DocumentService $documentService,
    ) {}

    /**
     * Reset pagination when category filter changes.
     */
    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when year filter changes.
     */
    public function updatedYearFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Set the document ID pending deletion confirmation.
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
     * Permanently delete the document after confirmation.
     */
    public function deleteDocument(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        $document = Document::find($this->deleteId);

        if ($document) {
            $this->authorize('delete', $document);
            $this->documentService->delete($document);
        }

        $this->deleteId = null;

        $this->dispatch('notify', message: 'Documento eliminado.');
    }

    public function render(): View
    {
        $documents = Document::query()
            ->with(['category', 'year', 'media'])
            ->when($this->categoryFilter, fn ($q) => $q->where('document_category_id', $this->categoryFilter))
            ->when($this->yearFilter, fn ($q) => $q->where('document_year_id', $this->yearFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.document-table', [
            'documents'  => $documents,
            'categories' => DocumentCategory::orderBy('name')->get(),
            'years'      => DocumentYear::orderBy('year', 'desc')->get(),
        ]);
    }
}
