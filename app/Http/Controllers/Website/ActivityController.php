<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $page     = $request->input('page', 1);
        $query    = $request->input('q', '');
        $cacheKey = "website.activities.{$page}.{$query}";

        $activities = Cache::remember($cacheKey, 300, function () use ($request) {
            return Activity::published()
                ->with('featuredImage')
                ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%' . $request->input('q') . '%'))
                ->latest('published_at')
                ->paginate(12);
        })->withQueryString();

        return view('website.activities.index', compact('activities'));
    }

    public function show(string $slug): View
    {
        $activity = Activity::published()
            ->where('slug', $slug)
            ->with('featuredImage')
            ->firstOrFail();

        $related = Activity::published()
            ->with('featuredImage')
            ->where('id', '!=', $activity->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('website.activities.show', compact('activity', 'related'));
    }
}
