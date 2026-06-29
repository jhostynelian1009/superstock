<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::query()->updateOrCreate(
            ['email' => 'admin@superstock.com'],
            [
                'name' => 'Administrador General',
                'document_number' => '0000000000',
                'phone' => '0999999999',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
                'is_primary_admin' => true,
            ]
        );

        // Empleado 1
        User::query()->updateOrCreate(
            ['email' => 'empleado1@superstock.com'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('password'),
                'role' => User::ROLE_EMPLOYEE,
                'is_active' => true,
            ]
        );

        // Empleado 2
        User::query()->updateOrCreate(
            ['email' => 'empleado2@superstock.com'],
            [
                'name' => 'María López',
                'password' => Hash::make('password'),
                'role' => User::ROLE_EMPLOYEE,
                'is_active' => true,
            ]
        );
    }
}
