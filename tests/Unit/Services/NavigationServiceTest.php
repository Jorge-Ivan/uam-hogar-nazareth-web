<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Models\Page;
use App\Services\NavigationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    Cache::flush();
});

it('filters only published pages with show_in_header true', function (): void {
    // Published + in header → should be included
    Page::factory()->create([
        'status'         => ContentStatus::Published,
        'published_at'   => now(),
        'show_in_header' => true,
    ]);

    // Draft + in header → excluded
    Page::factory()->create([
        'status'         => ContentStatus::Draft,
        'show_in_header' => true,
    ]);

    // Published + NOT in header → excluded
    Page::factory()->create([
        'status'         => ContentStatus::Published,
        'published_at'   => now(),
        'show_in_header' => false,
    ]);

    $service = new NavigationService();
    $pages   = $service->headerPages();

    expect($pages)->toHaveCount(1);
});

it('filters only published pages with show_in_footer true', function (): void {
    // Published + in footer → included
    Page::factory()->create([
        'status'         => ContentStatus::Published,
        'published_at'   => now(),
        'show_in_footer' => true,
    ]);

    // Draft + in footer → excluded
    Page::factory()->create([
        'status'         => ContentStatus::Draft,
        'show_in_footer' => true,
    ]);

    $service = new NavigationService();
    $pages   = $service->footerPages();

    expect($pages)->toHaveCount(1);
});

it('caches nav header result and second call does not hit database', function (): void {
    Page::factory()->create([
        'status'         => ContentStatus::Published,
        'published_at'   => now(),
        'show_in_header' => true,
    ]);

    $service = new NavigationService();
    $service->headerPages(); // warm cache

    // Second call should hit cache — query count should be 0
    $queryCount = 0;
    DB::listen(function () use (&$queryCount): void {
        $queryCount++;
    });

    $service->headerPages();

    expect($queryCount)->toBe(0);
});

it('caches nav footer result and second call does not hit database', function (): void {
    Page::factory()->create([
        'status'         => ContentStatus::Published,
        'published_at'   => now(),
        'show_in_footer' => true,
    ]);

    $service = new NavigationService();
    $service->footerPages(); // warm cache

    $queryCount = 0;
    DB::listen(function () use (&$queryCount): void {
        $queryCount++;
    });

    $service->footerPages();

    expect($queryCount)->toBe(0);
});
