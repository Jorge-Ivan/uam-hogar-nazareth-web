<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        $activities = Activity::published()
            ->with('featuredImage')
            ->latest('published_at')
            ->limit(6)
            ->get();

        $events = Event::where('start_date', '>=', now())
            ->with('featuredImage')
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        return view('website.home', compact('activities', 'events'));
    }
}
