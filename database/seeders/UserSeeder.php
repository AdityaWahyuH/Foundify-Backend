<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'username' => 'aditya',
                'email' => 'aditywh@gmail.com',
                'password' => Hash::make('password123'),
                'nama' => 'Aditya Wahyu Hidayatullah',
                'no_telp' => '081234567890',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'fikri',
                'email' => 'fikri@gmail.com',
                'password' => Hash::make('password123'),
                'nama' => 'Mohamad Fikri Isfahani',
                'no_telp' => '081234567891',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'joe',
                'email' => 'joe@gmail.com',
                'password' => Hash::make('password123'),
                'nama' => 'Joe Petra',
                'no_telp' => '081234567892',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'abel',
                'email' => 'abel@gmail.com',
                'password' => Hash::make('password123'),
                'nama' => 'Abel Chrisnaldi',
                'no_telp' => '081234567893',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
