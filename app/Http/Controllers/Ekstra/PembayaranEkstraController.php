<?php

namespace App\Http\Controllers\Ekstra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembayaranEkstra;
use App\Models\EkstraSiswa;
use Illuminate\Support\Facades\Validator;

class PembayaranEkstraController extends Controller
{
    public function createPembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|string|max:10|exists:siswa,id_siswa',
            'nama_siswa' => 'required|string|max:255|exists:siswa,nama_siswa',
            'id_ekstra_siswa' => 'required|exists:ekstra_siswa,id_ekstra_siswa',
            'tanggal_pembayaran' => 'required|date',
            'nominal' => 'required|integer|regex:/^\d+$/',
            'catatan' => 'nullable|string'
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

        $ekstraSiswa = EkstraSiswa::find($request->id_ekstra_siswa);

        if ($ekstraSiswa->id_siswa !== $request->id_siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekstra siswa tidak sesuai dengan siswa yang dimaksud.'
            ], 400);
        }

        if ($ekstraSiswa->tagihan_ekstra < $request->nominal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nominal pembayaran melebihi tagihan.'
            ], 400);
        }

        try {
            $idUser = auth()->user()->id_user;

            $pembayaran = PembayaranEkstra::create([
                'id_pembayaran_ekstra' => PembayaranEkstra::generateId(),
                'id_siswa' => $ekstraSiswa->id_siswa,
                'id_user' => $idUser,
                'id_ekstra_siswa' => $request->id_ekstra_siswa,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'nominal' => $request->nominal,
                'catatan' => $request->catatan
            ]);

            // Update tagihan_ekstra
            $ekstraSiswa->tagihan_ekstra -= $request->nominal;
            $ekstraSiswa->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dicatat dan tagihan berhasil diperbarui',
                'data' => $pembayaran
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }

    }

}
