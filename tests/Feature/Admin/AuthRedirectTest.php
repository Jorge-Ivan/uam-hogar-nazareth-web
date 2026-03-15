<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;

it('redirects unauthenticated users from /admin/dashboard to login', function (): void {
    $this->get('/admin/dashboard')
        ->assertRedirect('/login');
});

it('redirects unauthenticated users from /admin/pages to login', function (): void {
    $this->get('/admin/pages')
        ->assertRedirect('/login');
});

it('redirects unauthenticated users from /admin/activities to login', function (): void {
    $this->get('/admin/activities')
        ->assertRedirect('/login');
});

it('redirects unauthenticated users from /admin/galleries to login', function (): void {
    $this->get('/admin/galleries')
        ->assertRedirect('/login');
});

it('redirects unauthenticated users from /admin/events to login', function (): void {
    $this->get('/admin/events')
        ->assertRedirect('/login');
});

it('redirects unauthenticated users from /admin/documents to login', function (): void {
    $this->get('/admin/documents')
        ->assertRedirect('/login');
});

it('allows admin users to access /admin/dashboard', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->get('/admin/dashboard')
        ->assertOk();
});

it('denies editor users from /admin routes with 403', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);

    $this->actingAs($editor)
        ->get('/admin/dashboard')
        ->assertForbidden();
});
