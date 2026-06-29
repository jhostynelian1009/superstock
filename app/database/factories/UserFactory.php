<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'document_number' => fake()->unique()->numerify('##########'),
            'phone' => fake()->numerify('09########'),
            'email' => fake()->unique()->safeEmail(),
            'role' => User::ROLE_EMPLOYEE,
            'is_active' => true,
            'is_primary_admin' => false,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => User::ROLE_ADMIN,
            'is_primary_admin' => false,
        ]);
    }

    public function primaryAdmin(): static
    {
        return $this->state(fn () => [
            'role' => User::ROLE_ADMIN,
            'is_primary_admin' => true,
        ]);
    }


    public function employee(): static
    {
        return $this->state(fn () => [
            'role' => User::ROLE_EMPLOYEE,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
