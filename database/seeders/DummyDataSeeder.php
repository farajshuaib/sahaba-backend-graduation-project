<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(NftSeeder::class);
        $this->call(WatchesSeeder::class);
        $this->call(CollectionCollaboratorSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(KYCSeeder::class);
    }
}
