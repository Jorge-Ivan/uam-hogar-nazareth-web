<?php

declare(strict_types=1);

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\View\View;

final class DocumentController extends Controller
{
    public function index(): View
    {
        $documents = Document::with(['category', 'media'])
            ->get()
            ->sortByDesc(fn (Document $d): int|string => $d->year ?? '')
            ->groupBy(fn (Document $d): string => $d->year ?? 'Sin año');

        return view('website.documents.index', compact('documents'));
    }
}
