<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $names = ["Arts", "Entertainment", "Music", "News", "Science", "Sports", "Technology",];

        return [
            'name' => $names[rand(0, count($names) - 1)],
        ];
    }
}
