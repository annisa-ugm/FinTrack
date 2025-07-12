<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KonsumsiSiswa;

class KonsumsiSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_konsumsi_siswa' => 1,
                'id_siswa' => 2,
                'tanggal_mulai' => '2025-05-02',
                'tanggal_selesai' => '2025-11-02',
                'tagihan_konsumsi' => 800000,
                'catatan' => 'Mengikuti konsumsi',
            ],
            [
                'id_konsumsi_siswa' => 2,
                'id_siswa' => 21,
                'tanggal_mulai' => '2025-05-02',
                'tanggal_selesai' => '2025-11-02',
                'tagihan_konsumsi' => 800000,
                'catatan' => 'Mengikuti konsumsi',
            ],
        ];

        foreach ($data as $item) {
            KonsumsiSiswa::create($item);
        }
    }
}
