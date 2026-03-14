<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a photo gallery collection.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 */
final class Gallery extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    /**
     * Get the images belonging to this gallery.
     */
    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->orderBy('position');
    }
}
