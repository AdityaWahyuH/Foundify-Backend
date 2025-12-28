<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatPoinSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('riwayat_poin')->insert([
            [
                // Aditya dapat 100 poin karena KTM yang dia temukan berhasil diklaim
                'poin_id' => 1,  // Poin milik Aditya
                'jumlah_poin' => 100,
                'keterangan' => 'Reward menemukan KTM - Klaim oleh Fikri berhasil diverifikasi',
                'tanggal_transaksi' => '2025-12-21 14:00:00',
            ],
            [
                // Aditya dapat 50 poin karena Flashdisk yang dia temukan berhasil diklaim
                'poin_id' => 1,  // Poin milik Aditya
                'jumlah_poin' => 50,
                'keterangan' => 'Reward menemukan Flashdisk - Klaim oleh Abel berhasil diverifikasi',
                'tanggal_transaksi' => '2025-12-25 11:00:00',
            ],
        ]);
    }
}
