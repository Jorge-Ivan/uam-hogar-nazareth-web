<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Document;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        $activities = Cache::remember('website.home.activities', 300, function () {
            return Activity::published()
                ->with('featuredImage')
                ->latest('published_at')
                ->limit(6)
                ->get();
        });

        $events = Cache::remember('website.home.events', 300, function () {
            return Event::where(function ($q) {
                    $q->where('start_date', '<=', now())
                      ->where(function ($q2) {
                          $q2->whereNull('end_date')
                             ->orWhere('end_date', '>=', now());
                      });
                })
                ->orWhere('start_date', '>', now())
                ->with('featuredImage')
                ->orderBy('start_date')
                ->limit(3)
                ->get();
        });

        $documentCount = Cache::remember('website.home.document_count', 300, fn () => Document::count());

        return view('website.home', compact('activities', 'events', 'documentCount'));
    }
}
