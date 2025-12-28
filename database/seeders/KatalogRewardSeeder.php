<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KatalogRewardSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('katalog_reward')->insert([
            [
                'nama_reward' => 'Voucher GoPay 25K',
                'deskripsi' => 'Voucher saldo GoPay senilai Rp 25.000',
                'poin_required' => 50,
                'stok' => 20,
                'gambar' => 'voucher-gopay-25k.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_reward' => 'Voucher GoPay 50K',
                'deskripsi' => 'Voucher saldo GoPay senilai Rp 50.000',
                'poin_required' => 100,
                'stok' => 15,
                'gambar' => 'voucher-gopay-50k.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_reward' => 'Voucher OVO 25K',
                'deskripsi' => 'Voucher saldo OVO senilai Rp 25.000',
                'poin_required' => 50,
                'stok' => 25,
                'gambar' => 'voucher-ovo-25k.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_reward' => 'Voucher Pulsa 10K',
                'deskripsi' => 'Pulsa All Operator senilai Rp 10.000',
                'poin_required' => 25,
                'stok' => 50,
                'gambar' => 'voucher-pulsa-10k.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_reward' => 'Merchandise Tumbler',
                'deskripsi' => 'Tumbler eksklusif Foundify 500ml',
                'poin_required' => 200,
                'stok' => 10,
                'gambar' => 'tumbler-foundify.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_reward' => 'Voucher Indomaret 100K',
                'deskripsi' => 'Voucher belanja Indomaret senilai Rp 100.000',
                'poin_required' => 250,
                'stok' => 5,
                'gambar' => 'voucher-indomaret.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_reward' => 'Kaos Foundify',
                'deskripsi' => 'Kaos eksklusif Foundify (SOLD OUT)',
                'poin_required' => 300,
                'stok' => 0,
                'gambar' => 'kaos-foundify.jpg',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
