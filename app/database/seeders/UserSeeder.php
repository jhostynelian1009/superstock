<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@snackconnect.com'],
            [
                'name' => 'Administrador',
                'document_number' => '0000000000',
                'phone' => '0999999999',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'is_primary_admin' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'cliente@snackconnect.com'],
            [
                'name' => 'Cliente Demo',
                'document_number' => '1234567890',
                'phone' => '0988128034',
                'password' => Hash::make('password'),
                'role' => User::ROLE_CLIENT,
            ]
        );
    }
}
