<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Document;

final class DocumentService
{
    public function create(array $data): Document
    {
        return Document::create($data);
    }

    public function update(Document $document, array $data): Document
    {
        $document->update($data);

        return $document->fresh();
    }

    /**
     * Permanently delete a document record.
     */
    public function delete(Document $document): void
    {
        $document->delete();
    }
}
