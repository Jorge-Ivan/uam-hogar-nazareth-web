<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\OptimizeImage;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Handles all media file operations: upload, delete, and URL resolution.
 */
final class MediaService
{
    /**
     * Store the uploaded file on disk, create a Media record, and dispatch
     * the OptimizeImage job when the file is an image.
     */
    public function upload(UploadedFile $file, string $directory): Media
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');

        $media = Media::create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'alt_text'  => null,
        ]);

        if (str_starts_with((string) $file->getMimeType(), 'image/')) {
            OptimizeImage::dispatch($media);
        }

        return $media;
    }

    /**
     * Remove the file from disk and delete the Media record.
     */
    public function delete(Media $media): void
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
    }

    /**
     * Return the publicly accessible URL for the given media file.
     */
    public function getUrl(Media $media): string
    {
        return Storage::disk('public')->url($media->file_path);
    }
}
