<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangDitemukanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barang_ditemukan')->insert([
            [
                'user_id' => 1,  // Aditya MENEMUKAN KTM (bukan punya dia)
                'nama_barang' => 'Kartu Tanda Mahasiswa',
                'deskripsi' => 'KTM atas nama mahasiswa Telkom University, NIM 1204230xxx.',
                'tanggal_ditemukan' => '2025-12-20',
                'lokasi' => 'Ditemukan di lorong Gedung B',
                'lokasi_barang_ditemukan' => 'Pos Satpam Utama',
                'jadwal_penjemputan' => '2025-12-27 09:00:00',
                'lokasi_penjemputan' => 'Pos Satpam Utama',
                'status' => 'tersedia',
                'foto' => 'ktm-mahasiswa.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,  // Fikri MENEMUKAN Power Bank
                'nama_barang' => 'Power Bank Xiaomi 10000mAh',
                'deskripsi' => 'Power bank warna hitam merk Xiaomi.',
                'tanggal_ditemukan' => '2025-12-21',
                'lokasi' => 'Ditemukan di meja kantin',
                'lokasi_barang_ditemukan' => 'Ruang Informasi Kampus',
                'jadwal_penjemputan' => null,
                'lokasi_penjemputan' => null,
                'status' => 'tersedia',
                'foto' => 'powerbank-xiaomi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,  // Joe MENEMUKAN Kacamata
                'nama_barang' => 'Kacamata Minus',
                'deskripsi' => 'Kacamata frame hitam, lensa minus.',
                'tanggal_ditemukan' => '2025-12-22',
                'lokasi' => 'Ditemukan di kursi perpustakaan',
                'lokasi_barang_ditemukan' => 'Perpustakaan Meja Informasi',
                'jadwal_penjemputan' => '2025-12-28 10:00:00',
                'lokasi_penjemputan' => 'Perpustakaan Lt.1',
                'status' => 'diklaim',
                'foto' => 'kacamata-minus.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,  // Abel MENEMUKAN Botol
                'nama_barang' => 'Botol Minum Tupperware',
                'deskripsi' => 'Botol minum warna biru 750ml.',
                'tanggal_ditemukan' => '2025-12-23',
                'lokasi' => 'Ditemukan di lapangan basket',
                'lokasi_barang_ditemukan' => 'Pos Satpam Utama',
                'jadwal_penjemputan' => null,
                'lokasi_penjemputan' => null,
                'status' => 'tersedia',
                'foto' => 'botol-tupperware.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,  // Aditya MENEMUKAN Flashdisk
                'nama_barang' => 'Flashdisk Sandisk 32GB',
                'deskripsi' => 'Flashdisk warna merah hitam.',
                'tanggal_ditemukan' => '2025-12-24',
                'lokasi' => 'Ditemukan di lab komputer',
                'lokasi_barang_ditemukan' => 'Lab Komputer FRI',
                'jadwal_penjemputan' => null,
                'lokasi_penjemputan' => null,
                'status' => 'selesai',
                'foto' => 'flashdisk-sandisk.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
