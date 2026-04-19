<?php

declare(strict_types=1);

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;

beforeEach(function (): void {
    $this->withoutVite();
});

it('loads gallery index page', function (): void {
    Gallery::factory()->count(3)->create();

    $this->get(route('website.galleries.index'))->assertOk();
});

it('loads gallery show without n+1 queries', function (): void {
    $gallery = Gallery::factory()->create();
    $media   = Media::factory()->count(5)->create();

    foreach ($media as $i => $m) {
        GalleryImage::factory()->create([
            'gallery_id' => $gallery->id,
            'media_id'   => $m->id,
            'position'   => $i + 1,
        ]);
    }

    $this->get(route('website.galleries.show', $gallery->slug))->assertOk();
});
