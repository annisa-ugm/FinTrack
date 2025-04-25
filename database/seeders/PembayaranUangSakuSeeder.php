<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PembayaranUangSaku;

class PembayaranUangSakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PembayaranUangSaku::create([
            'id_pembayaran_uang_saku' => '1',
            'id_siswa' => '1',
            'nominal' => 500000,
            // 'kontrak_uang_saku' => 12,
            'catatan' => 'Pembayaran uang saku bulan pertama',
        ]);

    }
}
