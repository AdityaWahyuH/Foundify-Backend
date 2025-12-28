<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangHilangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barang_hilang')->insert([
            [
                'user_id' => 1,
                'nama_barang' => 'Laptop ASUS ROG Strix',
                'deskripsi' => 'Laptop gaming warna hitam dengan stiker anime di bagian cover. RAM 16GB, SSD 512GB.',
                'tanggal_hilang' => '2025-12-20',
                'lokasi' => 'Gedung Kuliah A Lantai 3',
                'status' => 'hilang',
                'foto' => 'laptop-asus.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'nama_barang' => 'Dompet Kulit Cokelat',
                'deskripsi' => 'Dompet kulit warna cokelat tua, ada KTP dan SIM atas nama Fikri.',
                'tanggal_hilang' => '2025-12-22',
                'lokasi' => 'Kantin Kampus Utama',
                'status' => 'hilang',
                'foto' => 'dompet-cokelat.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'nama_barang' => 'Kunci Motor Honda',
                'deskripsi' => 'Kunci motor Honda Beat dengan gantungan kunci biru berbentuk bola.',
                'tanggal_hilang' => '2025-12-23',
                'lokasi' => 'Parkiran Motor Timur',
                'status' => 'hilang',
                'foto' => 'kunci-motor.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'nama_barang' => 'Earphone Samsung Galaxy Buds',
                'deskripsi' => 'Earphone wireless warna putih dalam case hitam.',
                'tanggal_hilang' => '2025-12-24',
                'lokasi' => 'Perpustakaan Lantai 2',
                'status' => 'ditemukan',
                'foto' => 'earphone-samsung.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'nama_barang' => 'Jaket Hoodie Hitam',
                'deskripsi' => 'Jaket hoodie warna hitam polos ukuran L, ada noda kopi kecil di lengan kanan.',
                'tanggal_hilang' => '2025-12-25',
                'lokasi' => 'Ruang Kelas FRI-01',
                'status' => 'hilang',
                'foto' => 'hoodie-hitam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
