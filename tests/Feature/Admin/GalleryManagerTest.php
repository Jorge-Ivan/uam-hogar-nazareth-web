<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Livewire\Admin\GalleryForm;
use App\Livewire\Admin\GalleryManager;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function (): void {
    Storage::fake('public');
    Queue::fake();
});

it('creates a gallery via GalleryForm', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(GalleryForm::class)
        ->set('title', 'Galería de Actividades 2024')
        ->set('slug', 'galeria-de-actividades-2024')
        ->set('description', 'Fotografías de las actividades del año 2024.')
        ->call('save');

    $this->assertDatabaseHas('galleries', [
        'title' => 'Galería de Actividades 2024',
        'slug'  => 'galeria-de-actividades-2024',
    ]);
});

it('uploads an image to a gallery via GalleryManager', function (): void {
    $admin   = User::factory()->create(['role' => UserRole::Admin]);
    $gallery = Gallery::factory()->create();

    $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

    Livewire::actingAs($admin)
        ->test(GalleryManager::class, ['gallery' => $gallery])
        ->set('imageUpload', $file)
        ->call('uploadImage');

    $this->assertDatabaseHas('gallery_images', [
        'gallery_id' => $gallery->id,
    ]);
});

it('removes an image from a gallery via GalleryManager', function (): void {
    $admin        = User::factory()->create(['role' => UserRole::Admin]);
    $gallery      = Gallery::factory()->create();
    $media        = Media::factory()->create();
    $galleryImage = GalleryImage::factory()->create([
        'gallery_id' => $gallery->id,
        'media_id'   => $media->id,
    ]);

    Livewire::actingAs($admin)
        ->test(GalleryManager::class, ['gallery' => $gallery])
        ->call('removeImage', $galleryImage->id);

    $this->assertDatabaseMissing('gallery_images', [
        'id' => $galleryImage->id,
    ]);
});
