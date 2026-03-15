<?php

declare(strict_types=1);

use App\Models\Event;
use App\Services\EventService;

it('creates an event with auto-generated slug', function (): void {
    $service = app(EventService::class);

    $event = $service->create([
        'title'      => 'Fiesta de Navidad',
        'start_date' => now()->addDays(30),
    ]);

    expect($event)->toBeInstanceOf(Event::class)
        ->and($event->title)->toBe('Fiesta de Navidad')
        ->and($event->slug)->toBe('fiesta-de-navidad');
});

it('creates an event with all optional fields', function (): void {
    $service = app(EventService::class);

    $event = $service->create([
        'title'       => 'Día del Voluntario',
        'description' => 'Celebración especial.',
        'start_date'  => now()->addDays(10),
        'end_date'    => now()->addDays(11),
        'location'    => 'Salón Principal',
    ]);

    expect($event->description)->toBe('Celebración especial.')
        ->and($event->location)->toBe('Salón Principal')
        ->and($event->end_date)->not->toBeNull();
});

it('updates an event', function (): void {
    $event = Event::factory()->create(['title' => 'Evento Original']);
    $service = app(EventService::class);

    $updated = $service->update($event, ['title' => 'Evento Actualizado']);

    expect($updated->title)->toBe('Evento Actualizado')
        ->and($updated->slug)->toBe('evento-actualizado');
});

it('updates an event location without changing slug', function (): void {
    $event = Event::factory()->create(['slug' => 'mi-evento']);
    $service = app(EventService::class);

    $updated = $service->update($event, ['location' => 'Nueva Ubicación']);

    expect($updated->location)->toBe('Nueva Ubicación')
        ->and($updated->slug)->toBe('mi-evento');
});
