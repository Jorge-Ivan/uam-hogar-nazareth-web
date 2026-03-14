<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Queued job that constrains an image to a maximum width of 1920 px
 * and re-encodes it as JPEG at 85 % quality to reduce file size.
 */
final class OptimizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int Maximum number of attempts before the job is marked as failed. */
    public int $tries = 3;

    public function __construct(
        public readonly Media $media,
    ) {}

    /**
     * Open the image from public storage, resize if wider than 1920 px,
     * and save back to the same path at reduced quality.
     */
    public function handle(): void
    {
        $fullPath = Storage::disk('public')->path($this->media->file_path);

        Image::configure(['driver' => config('media.image_driver', 'gd')]);

        $image = Image::make($fullPath);

        $maxWidth = (int) config('media.max_width', 1920);

        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint): void {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $image->save($fullPath, (int) config('media.encode_quality', 85));
    }
}
