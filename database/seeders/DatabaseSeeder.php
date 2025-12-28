<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            BarangHilangSeeder::class,
            BarangDitemukanSeeder::class,
            KlaimSeeder::class,
            PoinSeeder::class,
            RiwayatPoinSeeder::class,
            KatalogRewardSeeder::class,
            TukarPoinSeeder::class,
        ]);
    }
}
