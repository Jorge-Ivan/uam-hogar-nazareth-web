<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a single image within a gallery.
 *
 * @property int $id
 * @property int $gallery_id
 * @property int $media_id
 * @property string|null $caption
 * @property int $position
 */
final class GalleryImage extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'gallery_id',
        'media_id',
        'caption',
        'position',
    ];

    /**
     * Get the gallery this image belongs to.
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get the media file for this gallery image.
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
