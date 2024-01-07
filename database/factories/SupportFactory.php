<?php

namespace Database\Factories;

use App\Enums\SupportRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Support>
 */
class SupportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'role' => SupportRole::MANAGER->value,
            'user_id' => User::factory()->asSupport(),
        ];
    }

    public function asMain(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => SupportRole::MAIN->value,
        ]);
    }
}
