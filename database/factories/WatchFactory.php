<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WatchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'nft_id' => Nft::inRandomOrder()->first()->id,
        ];
    }
}
