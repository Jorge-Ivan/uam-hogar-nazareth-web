<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for the admin user listing table.
 *
 * Provides search, pagination, and delete confirmation for User records.
 */
final class UserTable extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public string $search = '';

    private UserService $userService;

    public function boot(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);
        $this->userService->delete($user, auth()->user());
        $this->dispatch('notify', message: 'Usuario eliminado correctamente.');
    }

    public function render(): View
    {
        $users = User::query()
            ->when($this->search, fn ($q) => $q->where(function ($q): void {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.user-table', compact('users'));
    }
}
