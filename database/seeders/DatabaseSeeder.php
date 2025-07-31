<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            // ProfilNagariSeeder::class,
            // PerangkatNagariSeeder::class,
            // LayananSeeder::class,
            // PengaturanSistemSeeder::class,
        ]);
    }
}