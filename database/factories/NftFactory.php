<?php

namespace Database\Factories;

use App\Models\Nft;
use Illuminate\Database\Eloquent\Factories\Factory;

class NftFactory extends Factory
{
    protected $model = Nft::class;

    public function definition(): array
    {
        $status = ['published', 'pending', 'canceled', 'deleted'];
        return [
            'title' => $this->faker->title,
            'collection_id' => rand(1,10),
            'user_id' => rand(1,10),
            'description' => $this->faker->paragraph('2'),
            'image_url' => $this->faker->url,
            'creator_address' => $this->faker->url,
            'price' => $this->faker->numberBetween(1,1000),
            'status' => $status[rand(0,3)],
            'is_for_sale' => $this->faker->boolean,
            'sale_end_at' => $this->faker->date,
        ];
    }
}
