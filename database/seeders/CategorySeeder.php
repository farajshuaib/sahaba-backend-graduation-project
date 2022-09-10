<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::factory()->count(10)->create();

    }
}
