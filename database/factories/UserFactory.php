<?php

namespace Database\Factories;

use App\Enums\UserStatus;
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
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'document_number' => fake()->unique()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('#### ####'),
            'avatar_path' => null,
            'status' => UserStatus::Inactivo,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'last_login_at' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Usuario activo.
     */
    public function activo(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Activo,
        ]);
    }

    /**
     * Usuario inactivo.
     */
    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Inactivo,
        ]);
    }

    /**
     * Usuario suspendido.
     */
    public function suspendido(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Suspendido,
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