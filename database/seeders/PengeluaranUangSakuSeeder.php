<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengeluaranUangSaku;

class PengeluaranUangSakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengeluaranUangSaku::create([
            'id_pengeluaran_uang_saku' => '1',
            'id_siswa' => '1',
            'nominal' => 100000,
            'nama_pengeluaran' => 'Beli Buku',
            'tanggal_pengeluaran' => '2024-03-13',
        ]);

    }
}
