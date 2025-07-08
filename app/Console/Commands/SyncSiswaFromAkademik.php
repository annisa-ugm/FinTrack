<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Siswa;

class SyncSiswaFromAkademik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-siswa-from-akademik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data siswa dari sistem akademik ke database lokal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai ambil data siswa dari API Akademik...');

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
            // Ambil nama wali dari data 'ayah' jika ada, atau ibu/wali jika tidak
            $namaWali = $siswa['ayah']['nama'] ??
                        $siswa['ibu']['nama'] ??
                        $siswa['wali']['nama'] ?? 'Tidak Ada Wali';

            $noHpWali = $siswa['ayah']['no_telepon'] ??
                        $siswa['ibu']['no_telepon'] ??
                        $siswa['wali']['no_telepon'] ?? '-';

            // Default kelas & kategori
            $level = '-';
            $kategori = '-';

            // Simpan/update ke tabel siswa
            Siswa::updateOrCreate(
                ['id_siswa' => (string) $siswa['id_siswa']],
                [
                    'nisn'       => $siswa['nisn'] ?? '-',
                    'nama_siswa' => $siswa['nama'] ?? '-',
                    'level'      => $level,
                    'kategori'   => $kategori,
                    'akademik'   => 'Praxis',
                    'nama_wali'  => $namaWali,
                    'no_hp_wali' => $noHpWali,
                ]
            );
        }

        $this->info('Sync selesai. Total siswa: ' . count($siswaList));
    }
}
