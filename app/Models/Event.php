<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a foundation event.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $location
 * @property int|null $featured_image_id
 */
final class Event extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location',
        'featured_image_id',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'start_date' => 'immutable_datetime',
        'end_date' => 'immutable_datetime',
    ];

    /**
     * Get the featured image for the event.
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }
}
