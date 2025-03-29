<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tagihan;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tagihan::create([
            'id_tagihan' => '1',
            'id_siswa' => '1',
            'tagihan_uang_kbm' => 500000,
            'tagihan_uang_spp' => 300000,
            'tagihan_uang_pemeliharaan' => 200000,
            'tagihan_uang_konsumsi' => 250000,
            'tagihan_uang_boarding' => 400000,
            'tagihan_uang_sumbangan' => 150000,
        ]);

    }
}
