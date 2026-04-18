<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class EventController extends Controller
{
    public function index(): View
    {
        return view('website.events.index');
    }

    public function show(string $slug): View
    {
        return view('website.events.show');
    }
}
