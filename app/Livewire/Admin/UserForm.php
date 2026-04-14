<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Livewire component for creating and editing admin Users.
 *
 * Handles validation, role assignment, and password management
 * via UserService.
 */
final class UserForm extends Component
{
    use AuthorizesRequests;

    #[Locked]
    public ?int $userId = null;

    public string $name                 = '';
    public string $email                = '';
    public string $role                 = '';
    public string $password             = '';
    public string $passwordConfirmation = '';

    private UserService $userService;

    public function boot(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function mount(?int $userId = null): void
    {
        $this->userId = $userId;

        if ($userId !== null) {
            $user = User::findOrFail($userId);
            $this->authorize('update', $user);
            $this->name  = $user->name;
            $this->email = $user->email;
            $this->role  = $user->role->value;
        } else {
            $this->authorize('create', User::class);
            $this->role = UserRole::Editor->value;
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        $uniqueRule = $this->userId !== null
            ? Rule::unique('users', 'email')->ignore($this->userId)
            : Rule::unique('users', 'email');

        $passwordRule = $this->userId !== null
            ? ['nullable', 'string', Password::min(8), 'same:passwordConfirmation']
            : ['required', 'string', Password::min(8), 'same:passwordConfirmation'];

        return [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', $uniqueRule],
            'role'                 => ['required', Rule::enum(UserRole::class)],
            'password'             => $passwordRule,
            'passwordConfirmation' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'name.required'     => 'El nombre es obligatorio.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'El correo electrónico no es válido.',
            'email.unique'      => 'Este correo electrónico ya está registrado.',
            'role.required'     => 'El rol es obligatorio.',
            'role.enum'         => 'El rol seleccionado no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.same'     => 'Las contraseñas no coinciden.',
        ];
    }

    public function save(): void
    {
        $this->validate($this->rules(), $this->messages());

        $data = [
            'name'     => $this->name,
            'email'    => $this->email,
            'role'     => $this->role,
            'password' => $this->password,
        ];

        if ($this->userId !== null) {
            $user = User::findOrFail($this->userId);
            $this->authorize('update', $user);
            $this->userService->update($user, $data);
            $message = 'Usuario actualizado correctamente.';
        } else {
            $this->authorize('create', User::class);
            $this->userService->create($data);
            $message = 'Usuario creado correctamente.';
        }

        $this->dispatch('notify', message: $message);
        $this->redirect(route('admin.users.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.user-form', [
            'roles' => UserRole::cases(),
        ]);
    }
}
