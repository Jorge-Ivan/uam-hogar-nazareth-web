<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Gallery;
use App\Services\GalleryService;

final class CreateGallery
{
    public function __construct(
        private readonly GalleryService $galleryService,
    ) {}

    public function execute(array $data): Gallery
    {
        return $this->galleryService->create($data);
    }
}
