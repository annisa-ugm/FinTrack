<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengeluaran::create([
            'id_pengeluaran' => '1',
            'id_user' => '1',
            'tanggal_pengeluaran' => '2024-03-13',
            'nama_pengeluaran' => 'Pembelian alat tulis',
            'nominal' => 200000,
            'kelompok_pengeluaran' => 'Operasional',
            'catatan' => 'Pembelian untuk kebutuhan administrasi sekolah',
        ]);

    }
}
