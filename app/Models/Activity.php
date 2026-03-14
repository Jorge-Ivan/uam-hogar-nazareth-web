<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a foundation activity post.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $content
 * @property int|null $featured_image_id
 * @property ContentStatus $status
 * @property \Illuminate\Support\Carbon|null $published_at
 */
final class Activity extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_id',
        'status',
        'published_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => ContentStatus::class,
        'published_at' => 'immutable_datetime',
    ];

    /**
     * Get the featured image for the activity.
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    /**
     * Scope a query to only include published activities.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published);
    }
}
