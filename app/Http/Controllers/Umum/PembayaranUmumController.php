<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PembayaranUmumController extends Controller
{
    public function createPembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'tanggal_pembayaran' => 'required|date',
            'uang_kbm' => 'nullable|integer|regex:/^\d+$/',
            'uang_pemeliharaan' => 'nullable|integer|regex:/^\d+$/',
            'uang_spp' => 'nullable|integer|regex:/^\d+$/',
            'uang_sumbangan' => 'nullable|integer|regex:/^\d+$/',
            'catatan' => 'nullable|string',
        ], [
            'regex' => 'Kolom :attribute tidak boleh mengandung titik atau koma.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid. Silakan periksa kembali.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Minimal satu jenis pembayaran harus diisi
        if (
            is_null($request->uang_kbm) &&
            is_null($request->uang_pemeliharaan) &&
            is_null($request->uang_spp) &&
            is_null($request->uang_sumbangan)
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimal satu jenis pembayaran harus diisi.'
            ], 422);
        }

        try {
            $idUser = auth()->user()->id_user;
            $jenisPembayaranList = [
                'uang_kbm' => 'KBM',
                'uang_pemeliharaan' => 'Pemeliharaan',
                'uang_spp' => 'SPP',
                'uang_sumbangan' => 'Sumbangan',
            ];

            $dataTersimpan = [];

            $tagihan = Tagihan::where('id_siswa', $request->id_siswa)->first();

            if (!$tagihan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tagihan untuk siswa ini tidak ditemukan.'
                ], 404);
            }

            // Validasi dulu semua jenis pembayaran: tidak boleh melebihi tagihan
            foreach ($jenisPembayaranList as $key => $label) {
                $nominal = $request->$key;
                if (!is_null($nominal)) {
                    $kolomTagihan = 'tagihan_' . $key;
                    $sisaTagihan = $tagihan->$kolomTagihan ?? 0;

                    if ($nominal > $sisaTagihan) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Pembayaran tidak bisa dilakukan karena nominal pembayaran {$label} ({$nominal}) lebih besar daripada sisa tagihan {$label} ({$sisaTagihan})."
                        ], 422);
                    }
                }
            }

            // Lakukan pembayaran dan update tagihan
            foreach ($jenisPembayaranList as $key => $label) {
                $nominal = $request->$key;
                if (!is_null($nominal)) {
                    $idPembayaran = Pembayaran::generateId();

                    $pembayaran = Pembayaran::create([
                        'id_pembayaran' => $idPembayaran,
                        'id_siswa' => $request->id_siswa,
                        'id_user' => $idUser,
                        'tanggal_pembayaran' => $request->tanggal_pembayaran,
                        'jenis_pembayaran' => $label,
                        'nominal' => $nominal,
                        'catatan' => $request->catatan,
                    ]);

                    $dataTersimpan[] = $pembayaran;

                    $kolomTagihan = 'tagihan_' . $key;
                    if (!is_null($tagihan->$kolomTagihan)) {
                        $tagihan->$kolomTagihan -= $nominal;
                    }
                }
            }

            $tagihan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dicatat dan tagihan siswa diperbarui.',
                'data' => $dataTersimpan
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

}
