<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Models\Page;
use App\Services\PageService;

it('creates a page with draft status by default', function (): void {
    $service = app(PageService::class);

    $page = $service->create([
        'title'   => 'Quiénes Somos',
        'content' => 'Somos una fundación dedicada al cuidado de adultos mayores.',
    ]);

    expect($page)->toBeInstanceOf(Page::class)
        ->and($page->title)->toBe('Quiénes Somos')
        ->and($page->slug)->toBe('quienes-somos')
        ->and($page->status)->toBe(ContentStatus::Draft)
        ->and($page->published_at)->toBeNull();
});

it('creates a page with a custom slug', function (): void {
    $service = app(PageService::class);

    $page = $service->create([
        'title'   => 'Historia',
        'slug'    => 'nuestra-historia',
        'content' => 'Contenido de la página.',
    ]);

    expect($page->slug)->toBe('nuestra-historia');
});

it('updates a page and regenerates slug from title when slug is not provided', function (): void {
    $page = Page::factory()->create(['title' => 'Viejo Título', 'slug' => 'viejo-titulo']);
    $service = app(PageService::class);

    $updated = $service->update($page, ['title' => 'Nuevo Título']);

    expect($updated->title)->toBe('Nuevo Título')
        ->and($updated->slug)->toBe('nuevo-titulo');
});

it('updates a page without changing slug when slug is explicitly provided', function (): void {
    $page = Page::factory()->create(['slug' => 'slug-original']);
    $service = app(PageService::class);

    $updated = $service->update($page, ['title' => 'Nuevo Título', 'slug' => 'slug-personalizado']);

    expect($updated->slug)->toBe('slug-personalizado');
});

it('publishes a page and sets published_at', function (): void {
    $page = Page::factory()->create(['status' => ContentStatus::Draft]);
    $service = app(PageService::class);

    $published = $service->publish($page);

    expect($published->status)->toBe(ContentStatus::Published)
        ->and($published->published_at)->not->toBeNull();
});

it('archives a page', function (): void {
    $page = Page::factory()->published()->create();
    $service = app(PageService::class);

    $archived = $service->archive($page);

    expect($archived->status)->toBe(ContentStatus::Archived);
});
