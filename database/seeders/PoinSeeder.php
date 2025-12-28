<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoinSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('poin')->insert([
            [
                // Aditya (user_id: 1) dapat poin karena MENEMUKAN barang
                // - Menemukan KTM → diklaim Fikri → approved → +100 poin
                // - Menemukan Flashdisk → diklaim Abel → approved → +50 poin
                'user_id' => 1,
                'total_poin' => 150,  // 100 + 50
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Fikri (user_id: 2) - belum dapat poin (klaim Power Bank masih pending)
                'user_id' => 2,
                'total_poin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Joe (user_id: 3) - belum ada yang klaim barang temuannya
                'user_id' => 3,
                'total_poin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Abel (user_id: 4) - belum ada yang klaim barang temuannya
                'user_id' => 4,
                'total_poin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
