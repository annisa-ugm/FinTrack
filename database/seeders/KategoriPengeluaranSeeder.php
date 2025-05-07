<?php

namespace Database\Seeders;

use App\Models\KategoriPengeluaran;
use Illuminate\Database\Seeder;

class KategoriPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_jenis_pengeluaran' => '1',
                'nama_kategori_pengeluaran' => 'Lomba'
            ],
            [
                'id_jenis_pengeluaran' => '1',
                'nama_kategori_pengeluaran' => 'Exhibition'
            ],
            [
                'id_jenis_pengeluaran' => '1',
                'nama_kategori_pengeluaran' => 'Alat Tulis'
            ],
            [
                'id_jenis_pengeluaran' => '2',
                'nama_kategori_pengeluaran' => 'Elektronik'
            ],
            [
                'id_jenis_pengeluaran' => '2',
                'nama_kategori_pengeluaran' => 'Kebersihan'
            ]
        ];

        foreach ($data as $item) {
            KategoriPengeluaran::create([
                'id_kategori_pengeluaran' => KategoriPengeluaran::generateId(),
                'id_jenis_pengeluaran' => $item['id_jenis_pengeluaran'],
                'nama_kategori_pengeluaran' => $item['nama_kategori_pengeluaran'],
            ]);
        }
    }
}
