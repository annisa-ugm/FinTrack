<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakSiswa;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KontrakController extends Controller
{

    public function createKontrak(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            // 'id_kontrak_siswa' => 'required|string|max:10|unique:kontrak_siswa,id_kontrak_siswa', (tidak usah karena sudah di generate otomatis)
            // 'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'nisn' => 'required|string|exists:siswa,nisn',
            'uang_kbm' => 'required|integer|regex:/^\d+$/',
            'uang_spp' => 'required|integer|regex:/^\d+$/',
            'uang_pemeliharaan' => 'required|integer|regex:/^\d+$/',
            'uang_boarding' => 'nullable|integer|regex:/^\d+$/',
            'uang_konsumsi' => 'nullable|integer|regex:/^\d+$/',
            'uang_sumbangan' => 'required|integer|regex:/^\d+$/',
            'catatan' => 'nullable|string',
            'file_kontrak' => 'required|mimes:pdf|max:10240'
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

            $idKontrak = KontrakSiswa::generateId();
            $idTagihan = Tagihan::generateId();

            $filePath = null;
            if ($request->hasFile('file_kontrak')) {
                $file = $request->file('file_kontrak');
                $extension = $file->getClientOriginalExtension();
                // $filePath = "kontrak_siswa/kontrak_{$request->id_siswa}.{$extension}";
                $filePath = "kontrak_siswa/kontrak_{$siswa->id_siswa}.{$extension}";
                $file->storeAs('public', $filePath);
            }

            $kontrak = KontrakSiswa::create([
                'id_kontrak_siswa' => $idKontrak,
                'id_siswa' => $siswa->id_siswa,
                'uang_kbm' => $request->uang_kbm,
                'uang_spp' => $request->uang_spp,
                'uang_pemeliharaan' => $request->uang_pemeliharaan,
                'uang_boarding' => $request->uang_boarding,
                'uang_konsumsi' => $request->uang_konsumsi,
                'uang_sumbangan' => $request->uang_sumbangan,
                'catatan' => $request->catatan,
                'file_kontrak' => $filePath,
            ]);

            // Simpan tagihan
            Tagihan::create([
                'id_tagihan' => $idTagihan,
                'id_siswa' => $siswa->id_siswa,
                'tagihan_uang_kbm' => $request->uang_kbm,
                'tagihan_uang_spp' => $request->uang_spp,
                'tagihan_uang_pemeliharaan' => $request->uang_pemeliharaan,
                'tagihan_uang_konsumsi' => $request->uang_konsumsi ?? 0,
                'tagihan_uang_boarding' => $request->uang_boarding ?? 0,
                'tagihan_uang_sumbangan' => $request->uang_sumbangan,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kontrak siswa dan tagihan berhasil disimpan.',
                'data' => $kontrak
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
