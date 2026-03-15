<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Activity;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use App\Policies\ActivityPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\EventPolicy;
use App\Policies\GalleryPolicy;
use App\Policies\PagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Page::class     => PagePolicy::class,
        Activity::class => ActivityPolicy::class,
        Gallery::class  => GalleryPolicy::class,
        Event::class    => EventPolicy::class,
        Document::class => DocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
