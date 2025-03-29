<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pembayaran::create([
            'id_pembayaran' => '1',
            'id_siswa' => '1',
            'id_user' => '1',
            'tanggal_pembayaran' => '2024-03-13',
            'jenis_pembayaran' => 'SPP',
            'nominal' => 500000,
            'catatan' => 'Pembayaran untuk bulan Maret',
        ]);

    }
}
