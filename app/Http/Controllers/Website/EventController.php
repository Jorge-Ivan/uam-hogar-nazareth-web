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
        $upcoming = Event::where('start_date', '>=', now())
            ->with('featuredImage')
            ->orderBy('start_date')
            ->get();

        $past = Event::where('start_date', '<', now())
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
