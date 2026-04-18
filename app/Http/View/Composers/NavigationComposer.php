<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use App\Services\NavigationService;
use Illuminate\View\View;

final class NavigationComposer
{
    public function __construct(
        private readonly NavigationService $navigationService,
    ) {}

    /**
     * Bind navigation data to the public layout view.
     */
    public function compose(View $view): void
    {
        $view->with('navHeaderPages', $this->navigationService->headerPages());
        $view->with('navFooterPages', $this->navigationService->footerPages());
    }
}
