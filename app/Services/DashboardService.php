<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;

/**
 * Provides summary data for the admin dashboard.
 */
final class DashboardService
{
    /**
     * Return counts and recent content for the dashboard view.
     *
     * @return array<string, mixed>
     */
    public function getSummary(): array
    {
        return [
            'totalPages'       => Page::count(),
            'totalActivities'  => Activity::count(),
            'totalGalleries'   => Gallery::count(),
            'totalEvents'      => Event::count(),
            'recentActivities' => Activity::with('featuredImage')->latest()->limit(5)->get(),
        ];
    }
}
