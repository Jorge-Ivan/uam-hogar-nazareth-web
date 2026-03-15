<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\GalleryImage;
use App\Services\GalleryService;

final class RemoveGalleryImage
{
    public function __construct(
        private readonly GalleryService $galleryService,
    ) {}

    public function execute(GalleryImage $galleryImage): void
    {
        $this->galleryService->removeImage($galleryImage);
    }
}
