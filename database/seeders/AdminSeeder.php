<?php

namespace Database\Seeders;

use App\Models\Admin;
use Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'username' => 'Faraj Shuaib',
            'email' => 'farajshuaib@gmail.com',
            'password' => Hash::make('password123')
        ])->assignRole('super-admin');

        Admin::create([
            'username' => 'Faraj Shuaib',
            'email' => 'faraj.shuaip97@gmail.com',
            'password' => Hash::make('password123')
        ])->assignRole('admin');

    }
}
