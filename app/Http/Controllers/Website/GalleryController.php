<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class GalleryController extends Controller
{
    public function index(): View
    {
        return view('website.galleries.index');
    }

    public function show(string $slug): View
    {
        return view('website.galleries.show');
    }
}
