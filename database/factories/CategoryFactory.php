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
        $icons = [
            "http://127.0.0.1:8000/images/nfts/cat1.png",
            "http://127.0.0.1:8000/images/nfts/cat2.png",
            "http://127.0.0.1:8000/images/nfts/cat3.png",
            "http://127.0.0.1:8000/images/nfts/cat4.png",
            "http://127.0.0.1:8000//images/nfts/cat5.png",
            "http://127.0.0.1:8000/images/nfts/cat6.png"
        ];
        return [
            'name' => $names[rand(0, count($names) - 1)],
            'icon' => $icons[rand(0, count($icons) - 1)],
        ];
    }
}
