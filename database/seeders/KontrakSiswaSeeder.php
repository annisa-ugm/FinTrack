<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KontrakSiswa;

class KontrakSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KontrakSiswa::create([
            'id_kontrak_siswa' => '1',
            'id_siswa' => '1',
            'uang_kbm' => 500000,
            'uang_spp' => 300000,
            'uang_pemeliharaan' => 200000,
            // 'uang_konsumsi' => 250000,
            // 'uang_boarding' => 400000,
            'uang_sumbangan' => 150000,
            'catatan' => 'Kontrak berlaku hingga Desember 2024',
            'file_kontrak' => 'kontrak_1.pdf',
        ]);

    }
}
