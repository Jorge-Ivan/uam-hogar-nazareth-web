<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;
use App\Policies\UserPolicy;

it('admin can view any users', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect((new UserPolicy)->viewAny($admin))->toBeTrue();
});

it('editor cannot view any users', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);

    expect((new UserPolicy)->viewAny($editor))->toBeFalse();
});

it('admin can create users', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect((new UserPolicy)->create($admin))->toBeTrue();
});

it('editor cannot create users', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);

    expect((new UserPolicy)->create($editor))->toBeFalse();
});

it('admin can delete another user', function (): void {
    $admin  = User::factory()->create(['role' => UserRole::Admin]);
    $target = User::factory()->create();

    expect((new UserPolicy)->delete($admin, $target))->toBeTrue();
});

it('admin cannot delete themselves', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect((new UserPolicy)->delete($admin, $admin))->toBeFalse();
});

it('editor cannot delete users', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $target = User::factory()->create();

    expect((new UserPolicy)->delete($editor, $target))->toBeFalse();
});
