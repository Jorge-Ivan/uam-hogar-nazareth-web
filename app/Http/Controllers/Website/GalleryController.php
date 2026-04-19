<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\View\View;

final class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::withCount('images')
            ->with(['images' => fn($q) => $q->with('media')->orderBy('position')->limit(1)])
            ->latest()
            ->paginate(12);

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
