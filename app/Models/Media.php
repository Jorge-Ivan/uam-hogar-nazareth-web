<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents an uploaded file (image or document).
 *
 * @property int $id
 * @property string $file_path
 * @property string $file_name
 * @property string $mime_type
 * @property int $file_size
 * @property string|null $alt_text
 */
final class Media extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'alt_text',
    ];
}
