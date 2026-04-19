<?php

declare(strict_types=1);

use App\Http\View\Composers\SettingsComposer;
use App\Models\SiteSetting;

it('injects siteSettings into the view', function (): void {
    $composer = new SettingsComposer();

    $view = Mockery::mock(\Illuminate\View\View::class);
    $view->shouldReceive('with')
        ->once()
        ->with('siteSettings', Mockery::type(SiteSetting::class));

    $composer->compose($view);
});
