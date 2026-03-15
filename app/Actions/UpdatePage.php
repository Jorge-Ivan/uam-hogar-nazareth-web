<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Page;
use App\Services\PageService;

final class UpdatePage
{
    public function __construct(
        private readonly PageService $pageService,
    ) {}

    public function execute(Page $page, array $data): Page
    {
        return $this->pageService->update($page, $data);
    }
}
