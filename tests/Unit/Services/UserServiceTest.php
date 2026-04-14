<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;
use App\Services\UserService;

it('creates a user via CreateUser action', function (): void {
    $service = app(UserService::class);

    $newUser = $service->create([
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'role'     => UserRole::Editor->value,
        'password' => 'secret123',
    ]);

    expect($newUser->email)->toBe('test@example.com');
    expect($newUser->role)->toBe(UserRole::Editor);
});

it('updates a user via UpdateUser action', function (): void {
    $user    = User::factory()->create(['name' => 'Old Name', 'role' => UserRole::Editor]);
    $service = app(UserService::class);

    $updated = $service->update($user, [
        'name'     => 'New Name',
        'email'    => $user->email,
        'role'     => $user->role->value,
        'password' => '',
    ]);

    expect($updated->name)->toBe('New Name');
});

it('does not change password when empty string provided', function (): void {
    $user    = User::factory()->create(['role' => UserRole::Editor]);
    $oldHash = $user->password;
    $service = app(UserService::class);

    $service->update($user, [
        'name'     => $user->name,
        'email'    => $user->email,
        'role'     => $user->role->value,
        'password' => '',
    ]);

    expect($user->fresh()->password)->toBe($oldHash);
});

it('deletes a user when not self', function (): void {
    $admin   = User::factory()->create(['role' => UserRole::Admin]);
    $target  = User::factory()->create();
    $service = app(UserService::class);

    $service->delete($target, $admin);

    $this->assertDatabaseMissing('users', ['id' => $target->id]);
});

it('throws when trying to delete self', function (): void {
    $admin   = User::factory()->create(['role' => UserRole::Admin]);
    $service = app(UserService::class);

    expect(fn () => $service->delete($admin, $admin))
        ->toThrow(\RuntimeException::class);
});
