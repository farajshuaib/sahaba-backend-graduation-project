<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $types = ['mint', 'set_for_sale', 'sale', 'update_price'];
        return [
            'to' => User::inRandomOrder()->first()->id,
            'from' => User::inRandomOrder()->first()->id,
            'nft_id' => Nft::inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(0.01, 5.0),
            'type' => $types[array_rand($types)],
        ];
    }
}
