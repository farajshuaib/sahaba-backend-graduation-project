<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(['id' => 1], ['name' => 'admin']);
        Role::updateOrCreate(['id' => 2], ['name' => 'user']);
    }
}
