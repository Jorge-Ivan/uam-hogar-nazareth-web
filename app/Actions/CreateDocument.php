<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Document;
use App\Services\DocumentService;

final class CreateDocument
{
    public function __construct(
        private readonly DocumentService $documentService,
    ) {}

    public function execute(array $data): Document
    {
        return $this->documentService->create($data);
    }
}
