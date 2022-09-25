<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NftFactory extends Factory
{
    protected $model = Nft::class;

    public function definition(): array
    {
        $status = ['published', 'pending', 'canceled', 'deleted'];
        $file_type = ['image', 'audio', 'video'];
        $images = [
            "http://127.0.0.1:8000/images/images/nfts/1.png",
            "http://127.0.0.1:8000/images/images/nfts/2.png",
            "http://127.0.0.1:8000/images/images/nfts/3.png",
            "http://127.0.0.1:8000/images/images/nfts/4.png",
            "http://127.0.0.1:8000/images/images/nfts/5.png",
            "http://127.0.0.1:8000/images/images/nfts/6.png",
            "http://127.0.0.1:8000/images/images/nfts/7.png",
            "http://127.0.0.1:8000/images/images/nfts/8.png",
            "http://127.0.0.1:8000/images/images/nfts/9.png",
            "http://127.0.0.1:8000/images/images/nfts/10.png",
            "http://127.0.0.1:8000/images/images/nfts/11.png",
            "http://127.0.0.1:8000/images/images/nfts/12.png",
            "http://127.0.0.1:8000/images/images/nfts/13.png",
            "http://127.0.0.1:8000/images/images/nfts/14.png",
            "http://127.0.0.1:8000/images/images/nfts/15.png",
            "http://127.0.0.1:8000/images/images/nfts/16.png",
        ];

        return [
            'title' => $this->faker->title,
            'collection_id' => Collection::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'nft_token_id' => $this->faker->unique()->numberBetween(1, 100000000000),
            'description' => $this->faker->paragraph('2'),
            'file_path' => $images[round(0, count($images) - 1)],
            'file_type' => $file_type[round(0, 3)],
            'creator_address' => $this->faker->url,
            'price' => $this->faker->numberBetween(1, 1000),
            'status' => $status[rand(0, 2)],
            'is_for_sale' => $this->faker->boolean,
            'sale_end_at' => $this->faker->date,
        ];
    }
}
