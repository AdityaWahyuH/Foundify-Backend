<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TukarPoinSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tukar_poin')->insert([
            [
                'user_id' => 2,
                'katalog_id' => 4,
                'jumlah_poin' => 25,
                'tanggal_tukar' => '2025-12-26 12:00:00',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'katalog_id' => 1,
                'jumlah_poin' => 50,
                'tanggal_tukar' => '2025-12-26 14:00:00',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'katalog_id' => 2,
                'jumlah_poin' => 100,
                'tanggal_tukar' => '2025-12-27 09:00:00',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
