<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UangSaku;

class UangSakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UangSaku::create([
            'id_uang_saku' => '1',
            'id_siswa' => '1',
            'saldo' => 1000000,
            'kontrak_uang_saku' => 12,
            'catatan' => 'Uang saku untuk tahun ajaran baru',
        ]);

    }
}
