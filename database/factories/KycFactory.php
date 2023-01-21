<?php

namespace Database\Factories;

use App\Models\Kyc;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kyc>
 */
class KycFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['male', 'female'];
        $author_types = ['creator', 'collector'];
        $statuses = ['on_review', 'approved', 'rejected', 'pending'];


        return [
            'gender' => $genders[rand(0, count($genders) - 1)],
            'country' => fake()->century(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'user_id' => User::inRandomOrder()->first()->id,
            'author_type' => $author_types[array_rand($author_types, 1)],
            'status' => $statuses[array_rand($statuses, 3)],
            'author_art_type' => fake()->paragraph,

        ];
    }
}
