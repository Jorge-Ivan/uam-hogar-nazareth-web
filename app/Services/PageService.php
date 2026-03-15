<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ContentStatus;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

final class PageService
{
    public function create(array $data): Page
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['status'] = $data['status'] ?? ContentStatus::Draft;

        return Page::create($data);
    }

    public function update(Page $page, array $data): Page
    {
        if (isset($data['title']) && ! isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $page->update($data);

        $this->clearNavigationCache();

        return $page->fresh();
    }

    public function publish(Page $page): Page
    {
        $page->update([
            'status'       => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->clearNavigationCache();

        return $page->fresh();
    }

    public function archive(Page $page): Page
    {
        $page->update(['status' => ContentStatus::Archived]);

        $this->clearNavigationCache();

        return $page->fresh();
    }

    public function delete(Page $page): void
    {
        $page->delete();

        $this->clearNavigationCache();
    }

    private function clearNavigationCache(): void
    {
        Cache::forget('nav.header');
        Cache::forget('nav.footer');
    }
}
