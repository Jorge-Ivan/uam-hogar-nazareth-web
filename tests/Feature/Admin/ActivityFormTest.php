<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Enums\UserRole;
use App\Livewire\Admin\ActivityForm;
use App\Models\Activity;
use App\Models\User;
use Livewire\Livewire;

it('creates an activity via ActivityForm using ActivityService', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(ActivityForm::class)
        ->set('title', 'Taller de Pintura')
        ->set('slug', 'taller-de-pintura')
        ->set('content', 'Descripción del taller de pintura para adultos mayores.')
        ->set('status', 'draft')
        ->call('save')
        ->assertRedirect(route('admin.activities.index'));

    $this->assertDatabaseHas('activities', [
        'title'  => 'Taller de Pintura',
        'slug'   => 'taller-de-pintura',
        'status' => ContentStatus::Draft->value,
    ]);
});

it('updates an existing activity via ActivityForm', function (): void {
    $admin    = User::factory()->create(['role' => UserRole::Admin]);
    $activity = Activity::factory()->create([
        'title'   => 'Título Original',
        'slug'    => 'titulo-original',
        'content' => 'Contenido original.',
        'status'  => ContentStatus::Draft,
    ]);

    Livewire::actingAs($admin)
        ->test(ActivityForm::class, ['activity' => $activity])
        ->set('title', 'Título Actualizado')
        ->set('slug', 'titulo-actualizado')
        ->call('save')
        ->assertRedirect(route('admin.activities.index'));

    $this->assertDatabaseHas('activities', [
        'id'    => $activity->id,
        'title' => 'Título Actualizado',
        'slug'  => 'titulo-actualizado',
    ]);
});

it('requires title and content', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(ActivityForm::class)
        ->set('title', '')
        ->set('content', '')
        ->call('save')
        ->assertHasErrors(['title', 'content']);
});

it('auto-generates slug from title on create', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(ActivityForm::class)
        ->set('title', 'Visita de Voluntarios')
        ->assertSet('slug', 'visita-de-voluntarios');
});

it('publishes activity and sets published_at via publish action', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(ActivityForm::class)
        ->set('title', 'Celebración de Cumpleaños')
        ->set('slug', 'celebracion-de-cumpleanos')
        ->set('content', 'Descripción de la celebración mensual de cumpleaños.')
        ->set('status', 'draft')
        ->call('publish')
        ->assertRedirect(route('admin.activities.index'));

    $activity = Activity::where('slug', 'celebracion-de-cumpleanos')->firstOrFail();

    expect($activity->status)->toBe(ContentStatus::Published)
        ->and($activity->published_at)->not->toBeNull();
});
