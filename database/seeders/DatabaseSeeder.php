<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            PasswordResetTokenSeeder::class,
            SessionSeeder::class,
            SiswaSeeder::class,
            PembayaranSeeder::class,
            KontrakSiswaSeeder::class,
            TagihanSeeder::class,
            EkstraSeeder::class,
            EkstraSiswaSeeder::class,
            PembayaranEkstraSeeder::class,
            UangSakuSeeder::class,
            PembayaranUangSakuSeeder::class,
            PengeluaranUangSakuSeeder::class,
            JenisPengeluaranSeeder::class,
            KategoriPengeluaranSeeder::class,
            PengeluaranSeeder::class,
            SubPengeluaranSeeder::class,
        ]);
    }
}
