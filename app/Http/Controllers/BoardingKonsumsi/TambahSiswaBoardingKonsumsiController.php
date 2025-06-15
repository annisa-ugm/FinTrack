<?php

namespace App\Http\Controllers\BoardingKonsumsi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardingSiswa;
use App\Models\KonsumsiSiswa;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TambahSiswaBoardingKonsumsiController extends Controller
{
    public function createSiswaBoarding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'nisn' => 'required|string|exists:siswa,nisn',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'tagihan' => 'required|integer|regex:/^\d+$/',
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

        try {
            // Cari siswa dulu berdasarkan NISN
            $siswa = Siswa::where('nisn', $request->nisn)->first();

            if (!$siswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa dengan NISN tersebut tidak ditemukan.'
                ], 404);
            }

            $sudahTerdaftar = BoardingSiswa::where('id_siswa', $siswa->id_siswa)->exists();

            if ($sudahTerdaftar) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa ini sudah terdaftar sebagai peserta boarding.'
                ], 409);
            }

            $idBoardingSiswa = BoardingSiswa::generateId();
            $boardingSiswa = BoardingSiswa::create([
                'id_boarding_siswa' => $idBoardingSiswa,
                'id_siswa' => $siswa->id_siswa,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tagihan_boarding' => $request->tagihan,
                'catatan' => $request->catatan,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Penambahan siswa yang mengikuti boarding berhasil dilakukan.',
                'data' => $boardingSiswa
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function createSiswaKonsumsi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'nisn' => 'required|string|exists:siswa,nisn',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'tagihan' => 'required|integer|regex:/^\d+$/',
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

        try {
            // Cari siswa dulu berdasarkan NISN
            $siswa = Siswa::where('nisn', $request->nisn)->first();

            if (!$siswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa dengan NISN tersebut tidak ditemukan.'
                ], 404);
            }

            $sudahTerdaftar = KonsumsiSiswa::where('id_siswa', $siswa->id_siswa)->exists();

            if ($sudahTerdaftar) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa ini sudah terdaftar sebagai peserta konsumsi.'
                ], 409);
            }

            $idKonsumsiSiswa = KonsumsiSiswa::generateId();
            $konsumsiSiswa = KonsumsiSiswa::create([
                'id_konsumsi_siswa' => $idKonsumsiSiswa,
                'id_siswa' => $siswa->id_siswa,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tagihan_konsumsi' => $request->tagihan,
                'catatan' => $request->catatan,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Penambahan siswa yang mengikuti konsumsi berhasil dilakukan.',
                'data' => $konsumsiSiswa,
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

