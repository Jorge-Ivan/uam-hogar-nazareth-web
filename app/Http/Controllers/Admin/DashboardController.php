<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

/**
 * Displays the admin dashboard with summary counts and recent content.
 */
final class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboard,
    ) {}

    /**
     * Show the admin dashboard.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', $this->dashboard->getSummary());
    }
}
