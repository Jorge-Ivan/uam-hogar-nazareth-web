<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hogarnazareth.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Nazareth2025!'),
                'role'     => UserRole::Admin,
            ]
        );
    }
}
