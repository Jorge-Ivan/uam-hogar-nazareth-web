<?php

declare(strict_types=1);

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;
use App\Services\GalleryService;

it('creates a gallery with auto-generated slug', function (): void {
    $service = app(GalleryService::class);

    $gallery = $service->create([
        'title'       => 'Actividades 2024',
        'description' => 'Fotos de las actividades del año.',
    ]);

    expect($gallery)->toBeInstanceOf(Gallery::class)
        ->and($gallery->title)->toBe('Actividades 2024')
        ->and($gallery->slug)->toBe('actividades-2024');
});

it('updates a gallery', function (): void {
    $gallery = Gallery::factory()->create(['title' => 'Galería Original']);
    $service = app(GalleryService::class);

    $updated = $service->update($gallery, ['title' => 'Galería Actualizada']);

    expect($updated->title)->toBe('Galería Actualizada')
        ->and($updated->slug)->toBe('galeria-actualizada');
});

it('adds an image to a gallery with the next position', function (): void {
    $gallery = Gallery::factory()->create();
    $media = Media::factory()->create();
    $service = app(GalleryService::class);

    $image = $service->addImage($gallery, $media, 'Pie de foto');

    expect($image)->toBeInstanceOf(GalleryImage::class)
        ->and($image->gallery_id)->toBe($gallery->id)
        ->and($image->media_id)->toBe($media->id)
        ->and($image->caption)->toBe('Pie de foto')
        ->and($image->position)->toBe(1);
});

it('assigns consecutive positions when adding multiple images', function (): void {
    $gallery = Gallery::factory()->create();
    $service = app(GalleryService::class);

    $image1 = $service->addImage($gallery, Media::factory()->create());
    $image2 = $service->addImage($gallery, Media::factory()->create());
    $image3 = $service->addImage($gallery, Media::factory()->create());

    expect($image1->position)->toBe(1)
        ->and($image2->position)->toBe(2)
        ->and($image3->position)->toBe(3);
});

it('removes an image from a gallery', function (): void {
    $gallery = Gallery::factory()->create();
    $image = GalleryImage::factory()->create(['gallery_id' => $gallery->id]);
    $imageId = $image->id;
    $service = app(GalleryService::class);

    $service->removeImage($image);

    expect(GalleryImage::find($imageId))->toBeNull();
});

it('reorders gallery images by updating positions', function (): void {
    $gallery = Gallery::factory()->create();
    $service = app(GalleryService::class);

    $img1 = GalleryImage::factory()->create(['gallery_id' => $gallery->id, 'position' => 1]);
    $img2 = GalleryImage::factory()->create(['gallery_id' => $gallery->id, 'position' => 2]);
    $img3 = GalleryImage::factory()->create(['gallery_id' => $gallery->id, 'position' => 3]);

    // Reverse the order
    $service->reorderImages($gallery, [$img3->id, $img1->id, $img2->id]);

    expect($img3->fresh()->position)->toBe(1)
        ->and($img1->fresh()->position)->toBe(2)
        ->and($img2->fresh()->position)->toBe(3);
});
