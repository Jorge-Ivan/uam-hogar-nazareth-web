<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentYear;
use App\Services\DocumentService;
use App\Services\MediaService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for uploading new transparency documents.
 *
 * Handles PDF upload via MediaService, then creates the Document
 * record through DocumentService. Redirects to the index on success.
 */
final class DocumentUploader extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public string $title = '';

    public string $description = '';

    public string $categoryId = '';

    public string $yearId = '';

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $fileUpload = null;

    public ?string $fileName = null;

    private DocumentService $documentService;

    private MediaService $mediaService;

    /**
     * Resolve services via Livewire boot — constructor injection is not supported by ComponentRegistry.
     */
    public function boot(DocumentService $documentService, MediaService $mediaService): void
    {
        $this->documentService = $documentService;
        $this->mediaService    = $mediaService;
    }

    /**
     * Capture the original filename when a file is selected.
     */
    public function updatedFileUpload(): void
    {
        $this->fileName = $this->fileUpload?->getClientOriginalName();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'categoryId'  => ['required', 'exists:document_categories,id'],
            'yearId'      => ['required', 'exists:document_years,id'],
            'fileUpload'  => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }

    /**
     * Upload the PDF and persist the Document record.
     */
    public function save(): void
    {
        $this->validate($this->rules());

        $this->authorize('create', Document::class);

        $media = $this->mediaService->upload($this->fileUpload, 'documents');

        $this->documentService->create([
            'title'                => $this->title,
            'description'          => $this->description,
            'document_category_id' => $this->categoryId,
            'document_year_id'     => $this->yearId,
            'media_id'             => $media->id,
        ]);

        session()->flash('success', 'Documento subido correctamente.');

        $this->redirect(route('admin.documents.index'), navigate: false);
    }

    public function render(): View
    {
        return view('livewire.admin.document-uploader', [
            'categories' => DocumentCategory::orderBy('name')->get(),
            'years'      => DocumentYear::orderBy('year', 'desc')->get(),
        ]);
    }
}
