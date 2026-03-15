<?php

declare(strict_types=1);

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Media;
use App\Services\DocumentService;

it('creates a document', function (): void {
    $category = DocumentCategory::factory()->create();
    $media    = Media::factory()->pdf()->create();
    $service  = app(DocumentService::class);

    $document = $service->create([
        'title'                => 'Registro DIAN 2024',
        'description'          => 'Documento oficial.',
        'document_category_id' => $category->id,
        'year'                 => '2024',
        'media_id'             => $media->id,
    ]);

    expect($document)->toBeInstanceOf(Document::class)
        ->and($document->title)->toBe('Registro DIAN 2024')
        ->and($document->document_category_id)->toBe($category->id)
        ->and($document->year)->toBe('2024')
        ->and($document->media_id)->toBe($media->id);
});

it('updates a document title and description', function (): void {
    $document = Document::factory()->create(['title' => 'Título Original']);
    $service  = app(DocumentService::class);

    $updated = $service->update($document, [
        'title'       => 'Título Actualizado',
        'description' => 'Nueva descripción.',
    ]);

    expect($updated->title)->toBe('Título Actualizado')
        ->and($updated->description)->toBe('Nueva descripción.');
});

it('updates a document media file', function (): void {
    $document = Document::factory()->create();
    $newMedia = Media::factory()->pdf()->create();
    $service  = app(DocumentService::class);

    $updated = $service->update($document, ['media_id' => $newMedia->id]);

    expect($updated->media_id)->toBe($newMedia->id);
});
