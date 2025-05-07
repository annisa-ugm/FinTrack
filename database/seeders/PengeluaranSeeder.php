<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_jenis_pengeluaran' => '1', // Project
                'id_user' => '1', 
                'nama_pengeluaran' => 'Persiapan Lomba Nasional',
                'total_pengeluaran' => 5000000
            ],
            [
                'id_jenis_pengeluaran' => '2', // Non Project
                'id_user' => '1',
                'nama_pengeluaran' => 'Perbaikan Elektronik Sekolah',
                'total_pengeluaran' => 2000000
            ]
        ];

        foreach ($data as $item) {
            Pengeluaran::create([
                'id_pengeluaran' => Pengeluaran::generateId(),
                'id_jenis_pengeluaran' => $item['id_jenis_pengeluaran'],
                'id_user' => $item['id_user'],
                'nama_pengeluaran' => $item['nama_pengeluaran'],
                'total_pengeluaran' => $item['total_pengeluaran'],
            ]);
        }
    }
}
