<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Siswa;

class SyncLevelSiswaFromAkademik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-level-siswa-from-akademik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync level siswa dari API Akademik ke database lokal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai sync level siswa...');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('AKADEMIK_API_TOKEN'),
            'Accept' => 'application/json',
        ])->get(env('AKADEMIK_API_URL') . '/siswa');

        if ($response->failed()) {
            $this->error('Gagal ambil data siswa.');
            return;
        }

        $siswaList = $response->json();

        foreach ($siswaList as $siswa) {
            $idSiswa = (string) $siswa['id_siswa'];

            // Panggil detail siswa by ID untuk ambil semester_siswa
            $detailResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('AKADEMIK_API_TOKEN'),
                'Accept' => 'application/json',
            ])->get(env('AKADEMIK_API_URL') . '/siswa/' . $idSiswa);

            if ($detailResponse->failed()) continue;

            $detail = $detailResponse->json();
            $semesterSiswa = $detail['data']['semester_siswa'] ?? [];

            // Cari semester_siswa dengan id_semester_siswa terbesar
            $semesterTerbaru = collect($semesterSiswa)->sortByDesc('id_semester_siswa')->first();

            $level = '-';
            if ($semesterTerbaru && isset($semesterTerbaru['semester']['kelas']['tingkat'])) {
                $namaKelas = $semesterTerbaru['semester']['kelas']['tingkat'];
                $level = 'Level ' . $namaKelas;
            }

            // Update ke siswa lokal
            Siswa::where('id_siswa', $idSiswa)->update([
                'level' => $level
            ]);
        }

        $this->info('Sync level siswa selesai.');
    }
}
