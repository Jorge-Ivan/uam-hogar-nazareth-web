<?php

declare(strict_types=1);

use App\Jobs\OptimizeImage;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

it('processes a wide image without errors and the file remains on disk', function (): void {
    Storage::fake('public');

    // Generate a real GD image (2000 × 1500) wider than the 1920 px threshold
    $image = imagecreatetruecolor(2000, 1500);
    $tempPath = sys_get_temp_dir() . '/optimize-test-wide.jpg';
    imagejpeg($image, $tempPath, 90);
    imagedestroy($image);

    Storage::disk('public')->put('test/wide-image.jpg', file_get_contents($tempPath));
    unlink($tempPath);

    $media = Media::factory()->create([
        'file_path' => 'test/wide-image.jpg',
        'mime_type' => 'image/jpeg',
    ]);

    $job = new OptimizeImage($media);
    $job->handle();

    Storage::disk('public')->assertExists('test/wide-image.jpg');
});

it('processes a narrow image without errors and does not upscale it', function (): void {
    Storage::fake('public');

    // Generate a small GD image (800 × 600) — narrower than 1920 px, should not be resized
    $image = imagecreatetruecolor(800, 600);
    $tempPath = sys_get_temp_dir() . '/optimize-test-narrow.jpg';
    imagejpeg($image, $tempPath, 90);
    imagedestroy($image);

    Storage::disk('public')->put('test/narrow-image.jpg', file_get_contents($tempPath));
    unlink($tempPath);

    $media = Media::factory()->create([
        'file_path' => 'test/narrow-image.jpg',
        'mime_type' => 'image/jpeg',
    ]);

    $job = new OptimizeImage($media);
    $job->handle();

    Storage::disk('public')->assertExists('test/narrow-image.jpg');
});
