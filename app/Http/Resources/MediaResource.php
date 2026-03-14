<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * Transforms a Media model into a JSON-ready array for API responses.
 *
 * @mixin Media
 */
final class MediaResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'file_name'  => $this->file_name,
            'mime_type'  => $this->mime_type,
            'file_size'  => $this->file_size,
            'alt_text'   => $this->alt_text,
            'url'        => Storage::disk('public')->url($this->file_path),
            'created_at' => $this->created_at,
        ];
    }
}
