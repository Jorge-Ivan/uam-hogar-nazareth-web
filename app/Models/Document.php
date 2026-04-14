<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// DocumentYear is no longer used — year is stored as plain text on this model.

/**
 * Represents an institutional transparency document.
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $document_category_id
 * @property string|null $year
 * @property int $media_id
 */
final class Document extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'description',
        'document_category_id',
        'year',
        'media_id',
    ];

    /**
     * Get the category this document belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    /**
     * Get the media file for this document.
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
