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
        $file_type = ['image', 'audio', 'video'];
        return [
            'title' => $this->faker->title,
            'collection_id' => rand(1, 10),
            'user_id' => rand(1, 10),
            'nft_token_id' => rand(1, 10),
            'description' => $this->faker->paragraph('2'),
            'file_url' => $this->faker->url,
            'file_type' => $file_type[round(0, 3)],
            'creator_address' => $this->faker->url,
            'price' => $this->faker->numberBetween(1, 1000),
            'status' => $status[rand(0, 2)],
            'is_for_sale' => $this->faker->boolean,
            'sale_end_at' => $this->faker->date,
        ];
    }
}
