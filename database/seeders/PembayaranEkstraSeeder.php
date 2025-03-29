<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PembayaranEkstra;

class PembayaranEkstraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PembayaranEkstra::create([
            'id_pembayaran_ekstra' => '1',
            'id_siswa' => '1',
            'id_ekstra' => '1',
            'nominal' => 500000,
            'catatan' => 'Pembayaran ekstra futsal bulan September',
        ]);

    }
}
