<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a static institutional page.
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property ContentStatus $status
 * @property bool $show_in_header
 * @property bool $show_in_footer
 * @property int $menu_order
 * @property \Illuminate\Support\Carbon|null $published_at
 */
final class Page extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'content',
        'status',
        'published_at',
        'show_in_header',
        'show_in_footer',
        'menu_order',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status'         => ContentStatus::class,
        'published_at'   => 'immutable_datetime',
        'show_in_header' => 'boolean',
        'show_in_footer' => 'boolean',
        'menu_order'     => 'integer',
    ];

    /**
     * Parent page (self-referencing). Deleting a parent sets this to null.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    /**
     * Child pages ordered by menu_order.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('menu_order');
    }

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published);
    }

    /**
     * Scope a query to pages shown in the header navigation (published only).
     */
    public function scopeInHeader(Builder $query): Builder
    {
        return $query->where('show_in_header', true)
                     ->where('status', ContentStatus::Published);
    }

    /**
     * Scope a query to pages shown in the footer (published only).
     */
    public function scopeInFooter(Builder $query): Builder
    {
        return $query->where('show_in_footer', true)
                     ->where('status', ContentStatus::Published);
    }
}
