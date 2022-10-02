<?php

namespace Database\Seeders;

use App\Models\Watch;
use Illuminate\Database\Seeder;

class WatchesSeeder extends Seeder
{
    public function run()
    {
        Watch::factory()->count(10000)->create();
    }
}
