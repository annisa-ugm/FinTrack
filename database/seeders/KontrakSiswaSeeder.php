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
        $data = [
            [
                'id_kontrak_siswa' => 1,
                'id_siswa' => 2,
                'uang_kbm' => 500000,
                'uang_spp' => 300000,
                'uang_pemeliharaan' => 200000,
                'uang_sumbangan' => 150000,
                'catatan' => 'Kontrak berlaku hingga Desember 2024',
                'file_kontrak' => 'kontrak_1.pdf',
            ],
            [
                'id_kontrak_siswa' => 2,
                'id_siswa' => 24,
                'uang_kbm' => 600000,
                'uang_spp' => 350000,
                'uang_pemeliharaan' => 250000,
                'uang_sumbangan' => 100000,
                'catatan' => 'Kontrak baru semester genap 2025',
                'file_kontrak' => 'kontrak_2.pdf',
            ],
            [
                'id_kontrak_siswa' => 3,
                'id_siswa' => 18,
                'uang_kbm' => 550000,
                'uang_spp' => 320000,
                'uang_pemeliharaan' => 220000,
                'uang_sumbangan' => 120000,
                'catatan' => 'Kontrak siswa',
                'file_kontrak' => 'kontrak_3.pdf',
            ],
        ];

        foreach ($data as $item) {
            KontrakSiswa::create($item);
        }
    }
}
