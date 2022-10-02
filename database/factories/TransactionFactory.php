<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'to' => User::inRandomOrder()->first()->id,
            'from' => User::inRandomOrder()->first()->id,
            'nft_id' => Nft::inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
