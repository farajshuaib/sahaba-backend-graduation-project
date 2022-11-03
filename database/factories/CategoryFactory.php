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
        $names_en = ["Arts", "Entertainment", "Music", "Science", "Sports", "Technology",];
        $names_ar = ["فن", "تسلية", "موسيقى", "علوم", "رياضة", "تقنية",];

        return [
            'name_en' => $names_en[rand(0, count($names_en) - 1)],
            'name_ar' => $names_ar[rand(0, count($names_ar) - 1)],
        ];
    }
}
