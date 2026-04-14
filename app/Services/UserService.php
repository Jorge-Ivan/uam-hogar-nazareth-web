<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\CreateUser;
use App\Actions\UpdateUser;
use App\Models\User;

final class UserService
{
    public function __construct(
        private readonly CreateUser $createUser,
        private readonly UpdateUser $updateUser,
    ) {}

    public function create(array $data): User
    {
        return $this->createUser->execute($data);
    }

    public function update(User $user, array $data): User
    {
        return $this->updateUser->execute($user, $data);
    }

    public function delete(User $user, User $currentUser): void
    {
        if ($user->id === $currentUser->id) {
            throw new \RuntimeException('No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
    }
}
