<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class GalleryController extends Controller
{
    public function index(): View
    {
        $version = (int) Cache::get('website.galleries.cache_v', 1);
        $page    = max(1, (int) request()->get('page', 1));

        $galleries = Cache::remember("website.galleries.{$version}.p{$page}", 300, function () {
            return Gallery::withCount('images')
                ->with('coverImage.media')
                ->latest()
                ->paginate(12);
        });

        return view('website.galleries.index', compact('galleries'));
    }

    public function show(string $slug): View
    {
        $gallery = Gallery::where('slug', $slug)
            ->with(['images' => fn($q) => $q->with('media')->orderBy('position')])
            ->firstOrFail();

        return view('website.galleries.show', compact('gallery'));
    }
}
