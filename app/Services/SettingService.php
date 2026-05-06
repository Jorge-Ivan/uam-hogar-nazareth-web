<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

final class SettingService
{
    public function get(): SiteSetting
    {
        return SiteSetting::instance();
    }

    public function update(array $data): SiteSetting
    {
        $settings = SiteSetting::instance();
        $settings->update($data);

        Cache::forget('site_settings');

        return $settings->fresh();
    }
}
