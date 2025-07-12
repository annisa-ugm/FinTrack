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
        $data = [
            [
                'id_tagihan' => 1,
                'id_siswa' => 2,
                'tagihan_uang_kbm' => 500000,
                'tagihan_uang_spp' => 300000,
                'tagihan_uang_pemeliharaan' => 200000,
                'tagihan_uang_sumbangan' => 150000,
            ],
            [
                'id_tagihan' => 2,
                'id_siswa' => 24,
                'tagihan_uang_kbm' => 600000,
                'tagihan_uang_spp' => 350000,
                'tagihan_uang_pemeliharaan' => 250000,
                'tagihan_uang_sumbangan' => 100000,
            ],
            [
                'id_tagihan' => 3,
                'id_siswa' => 18,
                'tagihan_uang_kbm' => 550000,
                'tagihan_uang_spp' => 320000,
                'tagihan_uang_pemeliharaan' => 0,
                'tagihan_uang_sumbangan' => 0,
            ],
        ];

        foreach ($data as $item) {
            Tagihan::create($item);
        }
    }
}
