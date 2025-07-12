<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ekstra;

class EkstraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_ekstra' => 1,
                'nama_ekstra' => 'Piano',
                'biaya_ekstra' => 250000,
            ],
            [
                'id_ekstra' => 2,
                'nama_ekstra' => 'Panahan',
                'biaya_ekstra' => 200000,
            ],
            [
                'id_ekstra' => 3,
                'nama_ekstra' => 'Voli',
                'biaya_ekstra' => 150000,
            ],
        ];

        foreach ($data as $item) {
            Ekstra::create($item);
        }
    }
}
