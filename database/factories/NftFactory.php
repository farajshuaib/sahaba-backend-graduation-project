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
            env('APP_URL') . "/images/nfts/1.png",
            env('APP_URL') . "/images/nfts/2.png",
            env('APP_URL') . "/images/nfts/3.png",
            env('APP_URL') . "/images/nfts/4.png",
            env('APP_URL') . "/images/nfts/5.png",
            env('APP_URL') . "/images/nfts/6.png",
            env('APP_URL') . "/images/nfts/7.png",
            env('APP_URL') . "/images/nfts/8.png",
            env('APP_URL') . "/images/nfts/9.png",
            env('APP_URL') . "/images/nfts/10.png",
            env('APP_URL') . "/images/nfts/11.png",
            env('APP_URL') . "/images/nfts/12.png",
            env('APP_URL') . "/images/nfts/13.png",
            env('APP_URL') . "/images/nfts/14.png",
            env('APP_URL') . "/images/nfts/15.png",
            env('APP_URL') . "/images/nfts/16.png",
        ];

        return [
            'title' => $this->faker->title,
            'collection_id' => Collection::inRandomOrder()->first()->id,
            'creator_id' => User::inRandomOrder()->first()->id,
            'owner_id' => User::inRandomOrder()->first()->id,
            'description' => $this->faker->paragraph('2'),
            'file_path' => $images[array_rand($images, 1)],
            'file_type' => 'image/png',
            'price' => $this->faker->numberBetween(0.01, 5.0),
            'status' => $status[rand(0, 1)],
            'is_for_sale' => $this->faker->boolean,
            'sale_end_at' => Carbon::now(),
        ];
    }
}
