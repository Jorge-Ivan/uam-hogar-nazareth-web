<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;

it('redirects unauthenticated user from /admin/dashboard', function (): void {
    $this->get('/admin/dashboard')->assertRedirect('/login');
});

it('redirects unauthenticated user from /admin/settings', function (): void {
    $this->get('/admin/settings')->assertRedirect('/login');
});

it('admin can access dashboard', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
});

it('admin can access settings', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin)->get('/admin/settings')->assertOk();
});

it('admin can access pages', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin)->get('/admin/pages')->assertOk();
});

it('admin can access activities', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin)->get('/admin/activities')->assertOk();
});

it('editor can access dashboard', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/dashboard')->assertOk();
});

it('editor can access pages', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/pages')->assertOk();
});

it('editor can access activities', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/activities')->assertOk();
});

it('editor can access galleries', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/galleries')->assertOk();
});

it('editor can access events', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/events')->assertOk();
});

it('editor can access documents', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/documents')->assertOk();
});

it('editor is forbidden from settings', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/settings')->assertForbidden();
});

it('editor is forbidden from users', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/users')->assertForbidden();
});
