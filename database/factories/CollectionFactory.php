<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph('5'),
            'category_id' => rand(1, 10),
            'collection_token_id' => rand(1, 10),
            'logo_image' => $this->faker->url,
            'banner_image' => $this->faker->url,
            'website_url' => $this->faker->url,
            'facebook_url' => $this->faker->url,
            'twitter_url' => $this->faker->url,
            'telegram_url' => $this->faker->url,
            'is_sensitive_content' => $this->faker->boolean,
        ];
    }
}
