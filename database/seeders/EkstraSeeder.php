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
        Ekstra::create([
            'id_ekstra' => '1',
            'nama_ekstra' => 'Piano',
            'biaya_ekstra' => 250000,
        ]);

    }
}
