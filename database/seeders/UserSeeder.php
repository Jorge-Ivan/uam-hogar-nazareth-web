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
        User::firstOrCreate(
            ['email' => 'admin@hogarnazareth.org'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('admin1234'),
                'role'     => UserRole::Admin,
            ]
        );

        User::firstOrCreate(
            ['email' => 'editor@hogarnazareth.org'],
            [
                'name'     => 'Editor',
                'password' => Hash::make('editor1234'),
                'role'     => UserRole::Editor,
            ]
        );
    }
}
