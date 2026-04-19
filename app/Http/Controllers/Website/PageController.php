<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

final class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::published()
            ->where('slug', $slug)
            ->with('parent:id,title,slug')
            ->firstOrFail();

        return view('website.pages.show', compact('page'));
    }
}
