<?php

declare(strict_types=1);

use App\Jobs\OptimizeImage;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
    Queue::fake();
});

it('creates a media record and dispatches OptimizeImage when uploading an image', function (): void {
    $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

    $service = app(MediaService::class);
    $media = $service->upload($file, 'activities');

    expect($media)->toBeInstanceOf(Media::class)
        ->and($media->file_name)->toBe('photo.jpg')
        ->and($media->mime_type)->toContain('image');

    Storage::disk('public')->assertExists($media->file_path);
    Queue::assertPushed(OptimizeImage::class);
});

it('creates a media record without dispatching OptimizeImage when uploading a PDF', function (): void {
    $file = UploadedFile::fake()->create('report.pdf', 500, 'application/pdf');

    $service = app(MediaService::class);
    $media = $service->upload($file, 'documents');

    expect($media)->toBeInstanceOf(Media::class)
        ->and($media->file_name)->toBe('report.pdf');

    Storage::disk('public')->assertExists($media->file_path);
    Queue::assertNotPushed(OptimizeImage::class);
});

it('deletes the file and the media record', function (): void {
    $file = UploadedFile::fake()->image('to-delete.jpg');
    $service = app(MediaService::class);
    $media = $service->upload($file, 'uploads');

    $filePath = $media->file_path;

    $service->delete($media);

    Storage::disk('public')->assertMissing($filePath);
    expect(Media::find($media->id))->toBeNull();
});

it('stores the correct metadata on the media record', function (): void {
    $file = UploadedFile::fake()->image('banner.png', 1920, 1080);

    $service = app(MediaService::class);
    $media = $service->upload($file, 'uploads');

    expect($media->file_name)->toBe('banner.png')
        ->and($media->file_size)->toBeGreaterThan(0)
        ->and($media->alt_text)->toBeNull()
        ->and($media->file_path)->toStartWith('uploads/');
});

it('returns the correct public URL via getUrl', function (): void {
    $file = UploadedFile::fake()->image('hero.jpg');
    $service = app(MediaService::class);
    $media = $service->upload($file, 'uploads');

    $url = $service->getUrl($media);

    expect($url)->toBeString()->toContain($media->file_path);
});
