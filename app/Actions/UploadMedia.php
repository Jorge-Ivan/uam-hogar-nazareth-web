<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;

/**
 * Single-responsibility action that delegates file uploads to MediaService.
 */
final class UploadMedia
{
    public function __construct(
        private readonly MediaService $mediaService,
    ) {}

    /**
     * Upload the given file to the specified directory and return the Media record.
     */
    public function execute(UploadedFile $file, string $directory = 'uploads'): Media
    {
        return $this->mediaService->upload($file, $directory);
    }
}
