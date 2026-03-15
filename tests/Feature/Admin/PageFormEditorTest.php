<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Livewire\Admin\PageForm;
use App\Models\Media;
use App\Models\Page;
use App\Models\User;
use Livewire\Livewire;

it('saves html content via PageForm', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $html = '<p>Texto de prueba con <strong>negritas</strong> y <em>cursivas</em>.</p>';

    Livewire::actingAs($admin)
        ->test(PageForm::class)
        ->set('title', 'Quiénes Somos')
        ->set('slug', 'quienes-somos')
        ->set('content', $html)
        ->set('status', 'draft')
        ->call('save')
        ->assertRedirect(route('admin.pages.index'));

    $this->assertDatabaseHas('pages', [
        'slug'    => 'quienes-somos',
        'content' => $html,
    ]);
});

it('loads media library via loadMediaLibrary action', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Media::factory()->count(3)->create(['mime_type' => 'image/jpeg']);

    $component = Livewire::actingAs($admin)
        ->test(PageForm::class)
        ->call('loadMediaLibrary');

    $component->assertSet('showMediaBrowser', true);

    expect($component->get('mediaItems'))->toHaveCount(3);
});
