<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Page;
use App\Services\PageService;

final class CreatePage
{
    public function __construct(
        private readonly PageService $pageService,
    ) {}

    public function execute(array $data): Page
    {
        return $this->pageService->create($data);
    }
}
