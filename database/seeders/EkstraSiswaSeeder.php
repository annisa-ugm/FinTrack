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
            'durasi' => 1,
            'tagihan_ekstra' => 500000,
            'catatan' => 'Mengikuti ekstra futsal',
        ]);

    }
}
