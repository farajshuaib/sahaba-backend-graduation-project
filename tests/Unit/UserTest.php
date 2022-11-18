<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function connect_to_wallet(): void
    {
        $response = $this->postJson('/connect-wallet', [
            'wallet' => '0x1234567890',
        ]);
        $this->assertOk();

        $response->assertJson([
            'wallet' => '0x1234567890',
        ]);
    }

    public function update_profile(): void
    {
        $response = $this->put('/my-profile', [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'username' => fake()->userName,
            'email' => fake()->email,
            'bio' => fake()->text,
        ]);
        $this->assertOk();
    }
}
