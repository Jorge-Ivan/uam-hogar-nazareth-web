<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

final class DonationsController extends Controller
{
    public function index(): View
    {
        $siteSettings = SiteSetting::instance()->load('donationQr');

        return view('website.donations', compact('siteSettings'));
    }
}
