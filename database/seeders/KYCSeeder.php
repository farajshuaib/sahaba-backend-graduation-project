<?php

namespace Database\Seeders;

use App\Models\Kyc;
use Illuminate\Database\Seeder;

class KYCSeeder extends Seeder
{
    public function run()
    {
        Kyc::factory()->count(10)->create();
    }
}
