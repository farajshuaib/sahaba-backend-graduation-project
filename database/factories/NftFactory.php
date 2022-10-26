<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\Nft;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class NftFactory extends Factory
{
    protected $model = Nft::class;

    public function definition(): array
    {
        $status = ['published', 'hidden'];
        $images = [
            "http://127.0.0.1:8000/images/nfts/1.png",
            "http://127.0.0.1:8000/images/nfts/2.png",
            "http://127.0.0.1:8000/images/nfts/3.png",
            "http://127.0.0.1:8000/images/nfts/4.png",
            "http://127.0.0.1:8000/images/nfts/5.png",
            "http://127.0.0.1:8000/images/nfts/6.png",
            "http://127.0.0.1:8000/images/nfts/7.png",
            "http://127.0.0.1:8000/images/images/nfts/8.png",
            "http://127.0.0.1:8000/images/nfts/9.png",
            "http://127.0.0.1:8000/images/nfts/10.png",
            "http://127.0.0.1:8000/images/nfts/11.png",
            "http://127.0.0.1:8000/images/nfts/12.png",
            "http://127.0.0.1:8000/images/nfts/13.png",
            "http://127.0.0.1:8000/images/nfts/14.png",
            "http://127.0.0.1:8000/images/nfts/15.png",
            "http://127.0.0.1:8000/images/nfts/16.png",
        ];

        return [
            'title' => $this->faker->title,
            'collection_id' => Collection::inRandomOrder()->first()->id,
            'creator_id' => User::inRandomOrder()->first()->id,
            'owner_id' => User::inRandomOrder()->first()->id,
            'token_id' => $this->faker->unique()->sha256(),
            'description' => $this->faker->paragraph('2'),
            'file_path' => $images[array_rand($images, 1)],
            'price' => $this->faker->numberBetween(0.01, 5.0),
            'status' => $status[rand(0, 1)],
            'is_for_sale' => $this->faker->boolean,
            'sale_end_at' => Carbon::now(),
        ];
    }
}
