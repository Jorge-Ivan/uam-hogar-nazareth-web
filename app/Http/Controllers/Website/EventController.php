<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;

final class EventController extends Controller
{
    public function index(): View
    {
        $upcoming = Event::where(function ($q) {
                $q->where('start_date', '>', now())
                  ->orWhere(function ($q2) {
                      $q2->where('start_date', '<=', now())
                         ->where(function ($q3) {
                             $q3->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                         });
                  });
            })
            ->with('featuredImage')
            ->orderBy('start_date')
            ->get();

        $past = Event::where('start_date', '<', now())
            ->where(function ($q) {
                $q->whereNotNull('end_date')
                  ->where('end_date', '<', now())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('end_date')
                         ->where('start_date', '<', now());
                  });
            })
            ->with('featuredImage')
            ->latest('start_date')
            ->paginate(9);

        return view('website.events.index', compact('upcoming', 'past'));
    }

    public function show(string $slug): View
    {
        $event = Event::where('slug', $slug)
            ->with('featuredImage')
            ->firstOrFail();

        return view('website.events.show', compact('event'));
    }
}
