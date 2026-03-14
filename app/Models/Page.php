<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a static institutional page.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property ContentStatus $status
 * @property \Illuminate\Support\Carbon|null $published_at
 */
final class Page extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'published_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => ContentStatus::class,
        'published_at' => 'immutable_datetime',
    ];

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published);
    }
}
