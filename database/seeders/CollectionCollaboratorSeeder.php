<?php

namespace Database\Seeders;

use App\Models\CollectionCollaborator;
use Illuminate\Database\Seeder;

class CollectionCollaboratorSeeder extends Seeder
{
    public function run()
    {
        CollectionCollaborator::factory()->count(10)->create();
    }
}
