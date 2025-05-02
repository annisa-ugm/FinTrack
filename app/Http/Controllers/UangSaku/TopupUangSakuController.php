<?php

namespace App\Http\Controllers\BoardingKonsumsi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\BoardingSiswa;
use App\Models\KonsumsiSiswa;
use Illuminate\Support\Facades\Validator;

class PembayaranBKController extends Controller
{
    public function createPembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'tanggal_pembayaran' => 'required|date',
            'uang_boarding' => 'nullable|integer|regex:/^\d+$/',
            'uang_konsumsi' => 'nullable|integer|regex:/^\d+$/',
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

        if (is_null($request->uang_boarding) && is_null($request->uang_konsumsi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimal satu jenis pembayaran harus diisi.'
            ], 422);
        }

        try {
            $idUser = auth()->user()->id_user;
            $dataTersimpan = [];

            // Ambil tagihan boarding dan konsumsi
            $tagihanBoarding = BoardingSiswa::where('id_siswa', $request->id_siswa)->first();
            $tagihanKonsumsi = KonsumsiSiswa::where('id_siswa', $request->id_siswa)->first();

            if (!$tagihanBoarding && !$tagihanKonsumsi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tagihan siswa tidak ditemukan.'
                ], 404);
            }

            // Cek dan proses pembayaran uang boarding
            if (!is_null($request->uang_boarding)) {
                if (!$tagihanBoarding) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data tagihan boarding siswa tidak ditemukan.'
                    ], 404);
                }

                if ($request->uang_boarding > $tagihanBoarding->tagihan_boarding) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Nominal pembayaran boarding melebihi sisa tagihan.'
                    ], 422);
                }

                $idPembayaran = Pembayaran::generateId();

                $pembayaran = Pembayaran::create([
                    'id_pembayaran' => $idPembayaran,
                    'id_siswa' => $request->id_siswa,
                    'id_user' => $idUser,
                    'tanggal_pembayaran' => $request->tanggal_pembayaran,
                    'jenis_pembayaran' => 'Boarding',
                    'nominal' => $request->uang_boarding,
                    'catatan' => $request->catatan,
                ]);

                // Kurangi tagihan boarding
                $tagihanBoarding->tagihan_boarding -= $request->uang_boarding;
                $tagihanBoarding->save();

                $dataTersimpan[] = $pembayaran;
            }

            // Cek dan proses pembayaran uang konsumsi
            if (!is_null($request->uang_konsumsi)) {
                if (!$tagihanKonsumsi) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data tagihan konsumsi siswa tidak ditemukan.'
                    ], 404);
                }

                if ($request->uang_konsumsi > $tagihanKonsumsi->tagihan_konsumsi) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Nominal pembayaran konsumsi melebihi sisa tagihan.'
                    ], 422);
                }

                $idPembayaran = Pembayaran::generateId();

                $pembayaran = Pembayaran::create([
                    'id_pembayaran' => $idPembayaran,
                    'id_siswa' => $request->id_siswa,
                    'id_user' => $idUser,
                    'tanggal_pembayaran' => $request->tanggal_pembayaran,
                    'jenis_pembayaran' => 'Konsumsi',
                    'nominal' => $request->uang_konsumsi,
                    'catatan' => $request->catatan,
                ]);

                // Kurangi tagihan konsumsi
                $tagihanKonsumsi->tagihan_konsumsi -= $request->uang_konsumsi;
                $tagihanKonsumsi->save();

                $dataTersimpan[] = $pembayaran;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dicatat dan tagihan siswa diperbarui.',
                'data' => $dataTersimpan
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
