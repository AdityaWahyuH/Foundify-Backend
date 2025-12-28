<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'username' => 'superadmin',
                'email' => 'admin@foundify',
                'password' => Hash::make('admin123'),
                'nama' => 'Super Admin Foundify',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin2',
                'email' => 'admin2@foundify',
                'password' => Hash::make('admin123'),
                'nama' => 'Admin Dua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
