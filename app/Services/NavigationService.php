<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class NavigationService
{
    /**
     * Returns published pages marked for header navigation,
     * with their published children eager-loaded, ordered by menu_order.
     * Result is cached for 5 minutes.
     */
    public function headerPages(): Collection
    {
        return Cache::remember('nav.header', 300, function (): Collection {
            return Page::published()
                ->inHeader()
                ->with(['children' => function ($query): void {
                    $query->published()->select('id', 'title', 'slug', 'parent_id', 'menu_order')
                          ->orderBy('menu_order');
                }])
                ->orderBy('menu_order')
                ->get();
        });
    }

    /**
     * Returns published pages marked for footer navigation,
     * ordered by menu_order.
     * Result is cached for 5 minutes.
     */
    public function footerPages(): Collection
    {
        return Cache::remember('nav.footer', 300, function (): Collection {
            return Page::published()
                ->inFooter()
                ->orderBy('menu_order')
                ->get();
        });
    }
}
