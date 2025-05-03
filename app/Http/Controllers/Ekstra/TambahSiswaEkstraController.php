<?php

namespace App\Http\Controllers\Ekstra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Ekstra;
use App\Models\EkstraSiswa;
use Illuminate\Support\Facades\Validator;

class TambahSiswaEkstraController extends Controller
{
    public function createSiswaEkstra(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|exists:siswa,nisn',
            'id_ekstra' => 'required|array',
            'id_ekstra.*' => 'string|exists:ekstra,id_ekstra',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid. Silakan periksa kembali.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $siswa = Siswa::where('nisn', $request->nisn)->first();

            if (!$siswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa dengan NISN tersebut tidak ditemukan.'
                ], 404);
            }

            $createdEkstra = [];

            foreach ($request->id_ekstra as $idEkstra) {
                $ekstra = Ekstra::where('id_ekstra', $idEkstra)->first();

                if (!$ekstra) {
                    continue; // skip kalau tidak ditemukan
                }

                $idEkstraSiswa = EkstraSiswa::generateId();

                $ekstraSiswa = EkstraSiswa::create([
                    'id_ekstra_siswa' => $idEkstraSiswa,
                    'id_siswa' => $siswa->id_siswa,
                    'id_ekstra' => $ekstra->id_ekstra,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'tagihan_ekstra' => $ekstra->harga_ekstra,
                    'catatan' => $request->catatan,
                ]);

                $createdEkstra[] = $ekstraSiswa;
            }

            if (empty($createdEkstra)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada data ekstra yang berhasil ditambahkan.'
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Penambahan siswa yang mengikuti ekstra berhasil dilakukan.',
                'data' => $createdEkstra
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
