<?php

namespace Database\Seeders;

use App\Models\SubPengeluaran;
use Illuminate\Database\Seeder;

class SubPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_pengeluaran' => '1', // pastikan id ini cocok dengan hasil dari PengeluaranSeeder
                'id_kategori_pengeluaran' => '1', // Lomba
                'id_user' => '1',
                'nama_sub_pengeluaran' => 'Pendaftaran Lomba',
                'nominal' => 3000000,
                'jumlah_item' => 1,
                'file_nota' => 'nota_pendaftaran.pdf',
                'tanggal_pengeluaran' => '2025-05-01',
            ],
            [
                'id_pengeluaran' => '1',
                'id_kategori_pengeluaran' => '3', // Alat Tulis
                'id_user' => '1',
                'nama_sub_pengeluaran' => 'Pembelian Spidol',
                'nominal' => 200000,
                'jumlah_item' => 10,
                'file_nota' => 'nota_spidol.pdf',
                'tanggal_pengeluaran' => '2025-05-02',
            ],
            [
                'id_pengeluaran' => '2',
                'id_kategori_pengeluaran' => '4', // Elektronik
                'id_user' => '1',
                'nama_sub_pengeluaran' => 'Perbaikan Proyektor',
                'nominal' => 1500000,
                'jumlah_item' => 1,
                'file_nota' => 'nota_proyektor.pdf',
                'tanggal_pengeluaran' => '2025-05-03',
            ]
        ];

        foreach ($data as $item) {
            SubPengeluaran::create([
                'id_sub_pengeluaran' => SubPengeluaran::generateId(),
                'id_pengeluaran' => $item['id_pengeluaran'],
                'id_kategori_pengeluaran' => $item['id_kategori_pengeluaran'],
                'id_user' => $item['id_user'],
                'nama_sub_pengeluaran' => $item['nama_sub_pengeluaran'],
                'nominal' => $item['nominal'],
                'jumlah_item' => $item['jumlah_item'],
                'file_nota' => $item['file_nota'],
                'tanggal_pengeluaran' => $item['tanggal_pengeluaran'],
            ]);
        }
    }
}
