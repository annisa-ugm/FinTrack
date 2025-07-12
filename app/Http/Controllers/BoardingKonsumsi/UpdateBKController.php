<?php

namespace App\Http\Controllers\BoardingKonsumsi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\BoardingSiswa;
use App\Models\KonsumsiSiswa;

class UpdateBKController extends Controller
{
    public function show($id)
    {
        $siswa = Siswa::with(['boarding', 'konsumsi'])->find($id);

        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'siswa' => [
                    'id_siswa' => $siswa->id_siswa,
                    'nama_siswa' => $siswa->nama_siswa,
                    'level' => $siswa->level,
                    'akademik' => $siswa->akademik,
                ],
                'boarding' => $siswa->boarding,
                'konsumsi' => $siswa->konsumsi,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $siswa = Siswa::find($id);

            if (!$siswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            $validated = $request->validate([
                'boarding.tanggal_mulai' => 'nullable|date',
                'boarding.tanggal_selesai' => 'nullable|date',
                'boarding.tagihan_boarding' => 'nullable|integer',
                'boarding.catatan' => 'nullable|string',

                'konsumsi.tanggal_mulai' => 'nullable|date',
                'konsumsi.tanggal_selesai' => 'nullable|date',
                'konsumsi.tagihan_konsumsi' => 'nullable|integer',
                'konsumsi.catatan' => 'nullable|string',
            ]);

            // Update boarding jika ada
            if ($siswa->boarding && isset($validated['boarding'])) {
                $siswa->boarding->update($validated['boarding']);
            }

            // Update konsumsi jika ada
            if ($siswa->konsumsi && isset($validated['konsumsi'])) {
                $siswa->konsumsi->update($validated['konsumsi']);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data boarding dan/atau konsumsi berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            \Log::error('UPDATE BK ERROR', [
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
