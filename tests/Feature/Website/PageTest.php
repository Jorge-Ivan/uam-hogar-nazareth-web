<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Models\Page;

beforeEach(function (): void {
    $this->withoutVite();
});

it('returns 404 for draft page', function (): void {
    Page::factory()->create([
        'status' => ContentStatus::Draft,
        'slug'   => 'draft-page',
    ]);

    $this->get(route('website.pages.show', 'draft-page'))->assertNotFound();
});

it('returns 200 for published page', function (): void {
    $page = Page::factory()->create([
        'status'       => ContentStatus::Published,
        'published_at' => now(),
    ]);

    $this->get(route('website.pages.show', $page->slug))
        ->assertOk()
        ->assertSee($page->title);
});

it('shows breadcrumb with parent link', function (): void {
    $parent = Page::factory()->create([
        'status'       => ContentStatus::Published,
        'published_at' => now(),
    ]);

    $child = Page::factory()->create([
        'status'       => ContentStatus::Published,
        'published_at' => now(),
        'parent_id'    => $parent->id,
    ]);

    $this->get(route('website.pages.show', $child->slug))
        ->assertOk()
        ->assertSee($parent->title);
});
