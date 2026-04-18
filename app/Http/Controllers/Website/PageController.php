<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class PageController extends Controller
{
    public function show(string $slug): View
    {
        return view('website.pages.show');
    }
}
