<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a year associated with institutional documents.
 *
 * @property int $id
 * @property int $year
 */
final class DocumentYear extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'year',
    ];

    /**
     * Get all documents belonging to this year.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
