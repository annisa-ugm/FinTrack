<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BoardingSiswa;

class BoardingSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_boarding_siswa' => 1,
                'id_siswa' => 2,
                'tanggal_mulai' => '2025-05-02',
                'tanggal_selesai' => '2025-11-02',
                'tagihan_boarding' => 2500000,
                'catatan' => 'Mengikuti boarding',
            ],
            [
                'id_boarding_siswa' => 2,
                'id_siswa' => 18,
                'tanggal_mulai' => '2025-05-02',
                'tanggal_selesai' => '2025-11-02',
                'tagihan_boarding' => 2500000,
                'catatan' => 'Mengikuti boarding',
            ],
        ];

        foreach ($data as $item) {
            BoardingSiswa::create($item);
        }
    }

}
