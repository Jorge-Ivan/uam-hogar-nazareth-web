<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

final class SiteSetting extends Model
{
    protected $guarded = [];

    public function donationQr(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'donation_qr_media_id');
    }

    /**
     * Returns the singleton settings row, creating it with defaults on first call.
     */
    public static function instance(): self
    {
        return Cache::remember('site_settings', 3600, fn () => static::firstOrCreate(
            ['id' => 1],
            ['org_name' => 'Fundación Centro de Bienestar del Anciano Nazareth'],
        ));
    }
}
