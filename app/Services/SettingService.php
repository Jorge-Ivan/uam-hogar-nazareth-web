<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;

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

        return $settings->fresh();
    }
}
