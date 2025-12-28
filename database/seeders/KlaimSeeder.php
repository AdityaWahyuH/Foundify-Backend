<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlaimSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('klaim')->insert([
            [
                // Fikri (user_id: 2) KLAIM KTM yang ditemukan Aditya (user_id: 1)
                // Jadi Aditya yang dapat poin!
                'user_id' => 2,  // Fikri = PEMILIK ASLI / KORBAN
                'barang_ditemukan_id' => 1,  // KTM ditemukan oleh Aditya
                'bukti_kepemilikan' => 'KTM ini milik saya, NIM 1204230031. Bisa dicek foto KTP untuk verifikasi nama.',
                'status' => 'approved',
                'tanggal_klaim' => '2025-12-21 10:30:00',
                'verified_at' => '2025-12-21 14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Abel (user_id: 4) KLAIM Flashdisk yang ditemukan Aditya (user_id: 1)
                // Jadi Aditya yang dapat poin!
                'user_id' => 4,  // Abel = PEMILIK ASLI
                'barang_ditemukan_id' => 5,  // Flashdisk ditemukan oleh Aditya
                'bukti_kepemilikan' => 'Flashdisk saya, ada file skripsi dengan nama saya di dalamnya.',
                'status' => 'approved',
                'tanggal_klaim' => '2025-12-25 09:00:00',
                'verified_at' => '2025-12-25 11:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Joe (user_id: 3) KLAIM Power Bank yang ditemukan Fikri (user_id: 2)
                // Jadi Fikri yang dapat poin!
                'user_id' => 3,  // Joe = PEMILIK ASLI
                'barang_ditemukan_id' => 2,  // Power Bank ditemukan oleh Fikri
                'bukti_kepemilikan' => 'Power bank saya, ada stiker nama di bagian belakang.',
                'status' => 'pending',
                'tanggal_klaim' => '2025-12-26 14:00:00',
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
