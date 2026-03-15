<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use Illuminate\View\View;

/**
 * Displays the admin dashboard with summary counts and recent content.
 */
final class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalPages'       => Page::count(),
            'totalActivities'  => Activity::count(),
            'totalGalleries'   => Gallery::count(),
            'totalEvents'      => Event::count(),
            'recentActivities' => Activity::with('featuredImage')->latest()->limit(5)->get(),
        ]);
    }
}
