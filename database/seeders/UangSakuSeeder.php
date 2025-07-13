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
        $data = [
            [
                'id_uang_saku' => 1,
                'id_siswa' => 2,
                'saldo' => 1000000,
                'catatan' => 'Uang saku untuk tahun ajaran baru',
            ],
            [
                'id_uang_saku' => 2,
                'id_siswa' => 14,
                'saldo' => -1500000,
                'catatan' => 'Uang saku tambahan (minus untuk testing) semester genap',
            ],
        ];

        foreach ($data as $item) {
            UangSaku::create($item);
        }
    }
}
