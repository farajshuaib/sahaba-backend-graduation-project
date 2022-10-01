<?php

namespace Database\Seeders;

use App\Models\Nft;
use Illuminate\Database\Seeder;

class NftSeeder extends Seeder
{
    public function run()
    {

        Nft::factory()->count(10000)->create();


    }
}
