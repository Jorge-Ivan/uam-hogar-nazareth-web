<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

final class GalleryService
{
    public function create(array $data): Gallery
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $gallery = Gallery::create($data);
        $this->flushGalleryCache();

        return $gallery;
    }

    public function update(Gallery $gallery, array $data): Gallery
    {
        if (isset($data['title']) && ! isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $gallery->update($data);
        $this->flushGalleryCache();

        return $gallery->fresh();
    }

    public function addImage(Gallery $gallery, Media $media, ?string $caption = null): GalleryImage
    {
        $nextPosition = $gallery->images()->max('position') + 1;

        $image = GalleryImage::create([
            'gallery_id' => $gallery->id,
            'media_id'   => $media->id,
            'caption'    => $caption,
            'position'   => $nextPosition,
        ]);

        $this->flushGalleryCache();

        return $image;
    }

    public function removeImage(GalleryImage $galleryImage): void
    {
        $galleryImage->delete();
        $this->flushGalleryCache();
    }

    /**
     * @param  array<int>  $orderedIds
     */
    public function reorderImages(Gallery $gallery, array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            $gallery->images()
                ->where('id', $id)
                ->update(['position' => $position + 1]);
        }

        $this->flushGalleryCache();
    }

    public function delete(Gallery $gallery): void
    {
        $gallery->images()->delete();
        $gallery->delete();
        $this->flushGalleryCache();
    }

    private function flushGalleryCache(): void
    {
        Cache::forget('website.home.galleries');
        $version = (int) Cache::get('website.galleries.cache_v', 1);
        Cache::put('website.galleries.cache_v', $version + 1, now()->addYear());
    }
}
