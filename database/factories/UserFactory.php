<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $status = ['enabled', 'pending'];
        return [
            'username' => fake()->name(),
            'email' => fake()->safeEmail(),
            'bio' => fake()->title,
            'wallet_address' => $this->faker->unique()->numberBetween(1,10000000000),
            'profile_photo' => $this->faker->imageUrl,
            'website_url' => $this->faker->url,
            'facebook_url' => $this->faker->url,
            'twitter_url' => $this->faker->url,
            'telegram_url' => $this->faker->url,
            'status' => $status[rand(0,1)],
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
