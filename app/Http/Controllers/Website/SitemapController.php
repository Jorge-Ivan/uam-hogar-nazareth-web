<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

final class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('sitemap.xml', 21_600, function (): string {
            $activities = Activity::published()
                ->select(['slug', 'published_at', 'updated_at'])
                ->latest('published_at')
                ->get();

            $events = Event::select(['slug', 'updated_at'])
                ->latest('updated_at')
                ->get();

            $galleries = Gallery::select(['slug', 'updated_at'])
                ->latest('updated_at')
                ->get();

            $pages = Page::published()
                ->select(['slug', 'published_at', 'updated_at'])
                ->get();

            return view('website.sitemap', compact('activities', 'events', 'galleries', 'pages'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}
