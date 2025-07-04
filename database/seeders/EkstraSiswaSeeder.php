<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EkstraSiswa;

class EkstraSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EkstraSiswa::create([
            'id_ekstra_siswa' => '1',
            'id_siswa' => '1',
            'id_ekstra' => '1',
            'tanggal_mulai' => '2025-05-02',
            'tanggal_selesai' => '2025-11-02',
            'tagihan_ekstra' => 250000,
            'catatan' => 'Mengikuti ekstra',
        ]);

    }
}
