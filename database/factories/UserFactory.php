<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'username' => fake()->name(),
            'email' => $this->faker->unique()->email(),
            'bio' => fake()->text,
            'wallet_address' => $this->faker->unique()->numberBetween(1, 10000000000),
            'status' => 'enabled',
            'is_verified' => $this->faker->boolean,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
