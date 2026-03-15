<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;
use Illuminate\Support\Str;

final class GalleryService
{
    public function create(array $data): Gallery
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        return Gallery::create($data);
    }

    public function update(Gallery $gallery, array $data): Gallery
    {
        if (isset($data['title']) && ! isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $gallery->update($data);

        return $gallery->fresh();
    }

    public function addImage(Gallery $gallery, Media $media, ?string $caption = null): GalleryImage
    {
        $nextPosition = $gallery->images()->max('position') + 1;

        return GalleryImage::create([
            'gallery_id' => $gallery->id,
            'media_id'   => $media->id,
            'caption'    => $caption,
            'position'   => $nextPosition,
        ]);
    }

    public function removeImage(GalleryImage $galleryImage): void
    {
        $galleryImage->delete();
    }

    /**
     * Reorder gallery images by providing an ordered array of GalleryImage IDs.
     *
     * @param  array<int>  $orderedIds
     */
    public function reorderImages(Gallery $gallery, array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            $gallery->images()
                ->where('id', $id)
                ->update(['position' => $position + 1]);
        }
    }
}
