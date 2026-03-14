<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a category type for institutional documents.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 */
final class DocumentCategory extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get all documents belonging to this category.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
