<?php

namespace App\Http\Controllers\UangSaku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembayaranUangSaku;
use App\Models\PengeluaranUangSaku;
use App\Models\UangSaku;
use Illuminate\Support\Facades\Validator;

class PengeluaranUangSakuController extends Controller
{
    public function createPengeluaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'nama_siswa' => 'required|string|max:255|exists:siswa,nama_siswa',
            'tanggal_pengeluaran' => 'required|date',
            'nominal' => 'required|integer|regex:/^\d+$/',
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
            $idUser = auth()->user()->id_user;
            $idPengeluaranUangSaku = PengeluaranUangSaku::generateId();

            $pengeluaran = PengeluaranUangSaku::create([
                'id_pengeluaran_uang_saku' => $idPengeluaranUangSaku,
                'id_siswa' => $request->id_siswa,
                'id_user' => $idUser,
                'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
                'nominal' => $request->nominal,
                'catatan' => $request->catatan,
            ]);

            // Cek apa siswa sudah punya record di tabel uang_saku
            $uangSaku = UangSaku::where('id_siswa', $request->id_siswa)->first();

            if ($uangSaku) {
                // Kurang nominal lama dengan yang baru
                $uangSaku->saldo -= $request->nominal;
                $uangSaku->save();
            } else {
                $idUangSaku = UangSaku::generateID();

                UangSaku::create([
                    'id_uang_saku' => $idUangSaku,
                    'id_siswa' => $request->id_siswa,
                    'saldo' => 0 - $request-> nominal,
                    'catatan' => $request->catatan,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil disimpan.',
                'data' => $pengeluaran
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
