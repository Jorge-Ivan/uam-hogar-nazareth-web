<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\View\Composers\NavigationComposer;
use App\Http\View\Composers\SettingsComposer;
use App\Services\ReCaptchaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ReCaptchaService::class, fn () => new ReCaptchaService(
            secretKey: (string) config('services.recaptcha.secret_key', ''),
            minScore:  (float) config('services.recaptcha.min_score', 0.4),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('es');

        View::composer('layouts.public', NavigationComposer::class);
        View::composer(['layouts.public', 'website.*'], SettingsComposer::class);
    }
}
