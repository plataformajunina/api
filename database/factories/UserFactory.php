<?php

namespace Database\Factories;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'role' => Role::PERSON->value,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function asSupport(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::SUPPORT->value,
        ]);
    }

    public function asTenant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::TENANT->value,
        ]);
    }

    public function asGroup(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::GROUP->value,
        ]);
    }
}
