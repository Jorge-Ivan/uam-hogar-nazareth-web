<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Livewire\Admin\UserForm;
use App\Livewire\Admin\UserTable;
use App\Models\User;
use Livewire\Livewire;

// Access control
it('admin can view user list', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin)->get('/admin/users')->assertOk();
});

it('editor cannot view user list', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);
    $this->actingAs($editor)->get('/admin/users')->assertForbidden();
});

it('admin can view create user form', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin)->get('/admin/users/create')->assertOk();
});

// UserForm: create user
it('admin can create a new editor user', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(UserForm::class)
        ->set('name', 'María González')
        ->set('email', 'maria@example.com')
        ->set('role', UserRole::Editor->value)
        ->set('password', 'secret123')
        ->set('passwordConfirmation', 'secret123')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'email' => 'maria@example.com',
        'role'  => 'editor',
    ]);
});

it('editor cannot create users via Livewire', function (): void {
    $editor = User::factory()->create(['role' => UserRole::Editor]);

    Livewire::actingAs($editor)
        ->test(UserForm::class)
        ->assertForbidden();
});

// UserForm: update user
it('admin can update an existing user', function (): void {
    $admin  = User::factory()->create(['role' => UserRole::Admin]);
    $target = User::factory()->create(['role' => UserRole::Editor, 'name' => 'Viejo Nombre']);

    Livewire::actingAs($admin)
        ->test(UserForm::class, ['userId' => $target->id])
        ->set('name', 'Nuevo Nombre')
        ->call('save')
        ->assertHasNoErrors();

    expect($target->fresh()->name)->toBe('Nuevo Nombre');
});

// UserTable: delete
it('admin can delete another user', function (): void {
    $admin  = User::factory()->create(['role' => UserRole::Admin]);
    $target = User::factory()->create(['role' => UserRole::Editor]);

    Livewire::actingAs($admin)
        ->test(UserTable::class)
        ->call('deleteUser', $target->id)
        ->assertHasNoErrors();

    expect(User::find($target->id))->toBeNull();
});

it('admin cannot delete themselves', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(UserTable::class)
        ->call('deleteUser', $admin->id)
        ->assertForbidden();
});

// Validation
it('email must be unique when creating', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    User::factory()->create(['email' => 'used@example.com', 'role' => UserRole::Editor]);

    Livewire::actingAs($admin)
        ->test(UserForm::class)
        ->set('email', 'used@example.com')
        ->set('name', 'Test')
        ->set('role', UserRole::Editor->value)
        ->set('password', 'secret123')
        ->set('passwordConfirmation', 'secret123')
        ->call('save')
        ->assertHasErrors(['email']);
});

it('passwords must match', function (): void {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    Livewire::actingAs($admin)
        ->test(UserForm::class)
        ->set('name', 'Test')
        ->set('email', 'test@example.com')
        ->set('role', UserRole::Editor->value)
        ->set('password', 'secret123')
        ->set('passwordConfirmation', 'different')
        ->call('save')
        ->assertHasErrors(['password']);
});

it('password is optional on update when not provided', function (): void {
    $admin  = User::factory()->create(['role' => UserRole::Admin]);
    $target = User::factory()->create(['email' => 'target@example.com', 'role' => UserRole::Editor]);
    $oldHash = $target->password;

    Livewire::actingAs($admin)
        ->test(UserForm::class, ['userId' => $target->id])
        ->set('name', 'Nombre Actualizado')
        ->set('password', '')
        ->set('passwordConfirmation', '')
        ->call('save')
        ->assertHasNoErrors();

    expect($target->fresh()->password)->toBe($oldHash);
});
