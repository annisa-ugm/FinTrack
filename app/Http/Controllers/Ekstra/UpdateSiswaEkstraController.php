<?php

namespace App\Http\Controllers\Ekstra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EkstraSiswa;

class UpdateSiswaEkstraController extends Controller
{
    public function detail($id) //id_ekstra_siswa
    {
        $ekstraSiswa = EkstraSiswa::with(['siswa', 'ekstra'])->find($id);

        if (!$ekstraSiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data ekstra siswa tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id_ekstra_siswa' => $ekstraSiswa->id_ekstra_siswa,
                'id_siswa' => $ekstraSiswa->id_siswa,
                'nama_siswa' => $ekstraSiswa->siswa->nama_siswa ?? null,
                'id_ekstra' => $ekstraSiswa->id_ekstra,
                'nama_ekstra' => $ekstraSiswa->ekstra->nama_ekstra ?? null,
                'tanggal_mulai' => $ekstraSiswa->tanggal_mulai,
                'tanggal_selesai' => $ekstraSiswa->tanggal_selesai,
                'tagihan_ekstra' => $ekstraSiswa->tagihan_ekstra,
                'catatan' => $ekstraSiswa->catatan
            ]
        ]);
    }

    public function update(Request $request, $id) //id_ekstra_siswa
    {
        try {
            $ekstraSiswa = EkstraSiswa::find($id);

            if (!$ekstraSiswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data ekstra siswa tidak ditemukan.'
                ], 404);
            }

            $validated = $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date',
                'tagihan_ekstra' => 'required|integer|min:0',
                'catatan' => 'nullable|string'
            ]);

            $ekstraSiswa->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Data ekstra siswa berhasil diperbarui.',
                'data' => $ekstraSiswa
            ]);
        } catch (\Exception $e) {
            \Log::error('ERROR UPDATE EKSTRA SISWA', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
