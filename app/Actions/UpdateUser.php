<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final class UpdateUser
{
    public function execute(User $user, array $data): User
    {
        $payload = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'role'  => $data['role'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        $user->update($payload);

        return $user->fresh();
    }
}
