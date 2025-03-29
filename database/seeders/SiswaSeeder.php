<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
            'id_siswa' => '1',
            'nama_siswa' => 'Ahmad Budi',
            'nisn' => '1234567890',
            'level' => 'X',
            'kategori' => 'Boarding',
            'akademik' => 'Praxis',
            'nama_wali' => 'Budi',
            'no_hp_wali' => '081234567890',
        ]);

    }
}
