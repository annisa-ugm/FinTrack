<?php

namespace Database\Seeders;

use App\Models\JenisPengeluaran;
use Illuminate\Database\Seeder;

class JenisPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_jenis_pengeluaran' => 'Project'
            ],
            [
                'nama_jenis_pengeluaran' => 'Non project'
            ]
        ];

        foreach ($data as $item) {
            JenisPengeluaran::create([
                'id_jenis_pengeluaran' => JenisPengeluaran::generateId(),
                'nama_jenis_pengeluaran' => $item['nama_jenis_pengeluaran'],
            ]);
        }
    }
}
