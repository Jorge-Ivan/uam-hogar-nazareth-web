<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Models\Activity;
use App\Models\Media;
use App\Services\ActivityService;

it('creates an activity with draft status by default', function (): void {
    $service = app(ActivityService::class);

    $activity = $service->create([
        'title'   => 'Taller de Manualidades',
        'content' => 'Descripción del taller.',
    ]);

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->title)->toBe('Taller de Manualidades')
        ->and($activity->slug)->toBe('taller-de-manualidades')
        ->and($activity->status)->toBe(ContentStatus::Draft)
        ->and($activity->published_at)->toBeNull();
});

it('creates an activity with a custom slug', function (): void {
    $service = app(ActivityService::class);

    $activity = $service->create([
        'title'   => 'Visita Médica',
        'slug'    => 'visita-medica-julio',
        'content' => 'Contenido.',
    ]);

    expect($activity->slug)->toBe('visita-medica-julio');
});

it('updates an activity', function (): void {
    $activity = Activity::factory()->create(['title' => 'Título Original']);
    $service = app(ActivityService::class);

    $updated = $service->update($activity, ['title' => 'Título Actualizado']);

    expect($updated->title)->toBe('Título Actualizado')
        ->and($updated->slug)->toBe('titulo-actualizado');
});

it('publishes an activity and sets published_at', function (): void {
    $activity = Activity::factory()->create(['status' => ContentStatus::Draft]);
    $service = app(ActivityService::class);

    $published = $service->publish($activity);

    expect($published->status)->toBe(ContentStatus::Published)
        ->and($published->published_at)->not->toBeNull();
});

it('archives an activity', function (): void {
    $activity = Activity::factory()->published()->create();
    $service = app(ActivityService::class);

    $archived = $service->archive($activity);

    expect($archived->status)->toBe(ContentStatus::Archived);
});

it('sets the featured image on an activity', function (): void {
    $activity = Activity::factory()->create();
    $media = Media::factory()->create();
    $service = app(ActivityService::class);

    $updated = $service->setFeaturedImage($activity, $media);

    expect($updated->featured_image_id)->toBe($media->id);
});
