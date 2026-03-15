<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;
use App\Services\GalleryService;

final class AddGalleryImage
{
    public function __construct(
        private readonly GalleryService $galleryService,
    ) {}

    public function execute(Gallery $gallery, Media $media, ?string $caption = null): GalleryImage
    {
        return $this->galleryService->addImage($gallery, $media, $caption);
    }
}
