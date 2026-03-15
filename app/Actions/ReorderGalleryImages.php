<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Gallery;
use App\Services\GalleryService;

final class ReorderGalleryImages
{
    public function __construct(
        private readonly GalleryService $galleryService,
    ) {}

    /**
     * @param  array<int>  $orderedIds
     */
    public function execute(Gallery $gallery, array $orderedIds): void
    {
        $this->galleryService->reorderImages($gallery, $orderedIds);
    }
}
