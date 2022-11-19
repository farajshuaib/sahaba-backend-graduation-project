<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'creator',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'collector',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $system_manager = Role::create([
            'name' => 'super-admin',
            'guard_name' => 'web'
        ]);

//        $system_manager->givePermissionTo(
//            Permissios::all()
//        );


    }
}
