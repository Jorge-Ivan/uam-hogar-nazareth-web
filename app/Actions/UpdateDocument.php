<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Document;
use App\Services\DocumentService;

final class UpdateDocument
{
    public function __construct(
        private readonly DocumentService $documentService,
    ) {}

    public function execute(Document $document, array $data): Document
    {
        return $this->documentService->update($document, $data);
    }
}
