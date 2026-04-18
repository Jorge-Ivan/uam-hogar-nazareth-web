<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;

final class SettingsComposer
{
    /**
     * Bind site settings to the public layout view.
     */
    public function compose(View $view): void
    {
        $view->with('siteSettings', SiteSetting::instance());
    }
}
