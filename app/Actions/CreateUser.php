<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final class CreateUser
{
    public function execute(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'role'     => $data['role'],
            'password' => $data['password'],
        ]);
    }
}
