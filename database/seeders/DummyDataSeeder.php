<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CollectionCollaboratorSeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(NftSeeder::class);
    }
}
