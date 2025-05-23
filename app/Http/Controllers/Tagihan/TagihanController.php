<?php

namespace App\Http\Controllers\Tagihan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\HasilTagihan;
use Illuminate\Support\Facades\Validator;

class TagihanController extends Controller
{
    public function indexTagihan()
    {
        $data = HasilTagihan::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'status' => 'success',
            'message' => 'Data tagihan berhasil diambil.',
            'data' => $data
        ]);

    }

    public function detailTagihan($nisn)
    {
        $siswa = Siswa::with('tagihan', 'konsumsi', 'ekstraSiswa', 'boarding', 'uangSaku')
            ->where('nisn', $nisn)
            ->first();

        if (!$siswa) {
            return response()->json(['message' => 'Nisn siswa tidak ditemukan'], 404);
        }

        $total_ekstra = $siswa->ekstraSiswa->sum('tagihan_ekstra');

        $tagihan_uang_saku = 0;
        if ($siswa->uangSaku && $siswa->uangSaku->saldo < 0) {
            $tagihan_uang_saku = abs($siswa->uangSaku->saldo);
        }

        $data = [
            'nama_siswa' => $siswa->nama_siswa,
            'nisn' => $siswa->nisn,
            'level' => $siswa->level,
            'akademik' => $siswa->akademik,
            'tagihan_uang_kbm' => number_format($siswa->tagihan->tagihan_uang_kbm ?? 0, 0, ',', '.'),
            'tagihan_uang_spp' => number_format($siswa->tagihan->tagihan_uang_spp ?? 0, 0, ',', '.'),
            'tagihan_uang_pemeliharaan' => number_format($siswa->tagihan->tagihan_uang_pemeliharaan ?? 0, 0, ',', '.'),
            'tagihan_uang_sumbangan' => number_format($siswa->tagihan->tagihan_uang_sumbangan ?? 0, 0, ',', '.'),
            'tagihan_konsumsi' => number_format($siswa->konsumsi->tagihan_konsumsi ?? 0, 0, ',', '.'),
            'tagihan_ekstra' => number_format($total_ekstra, 0, ',', '.'),
            'tagihan_boarding' => number_format($siswa->boarding->tagihan_boarding ?? 0, 0, ',', '.'),
            'tagihan_uang_saku' => number_format($tagihan_uang_saku, 0, ',', '.'),
        ];

        return response()->json($data);
    }

    public function createTagihan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|exists:siswa,nisn',
            'file_tagihan' => 'required|mimes:pdf|max:10240'
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

            $idHasilTagihan = HasilTagihan::generateId();
            $idUser = auth()->user()->id_user;

            $filePath = null;
            if ($request->hasFile('file_tagihan')) {
                $file = $request->file('file_tagihan');
                $extension = $file->getClientOriginalExtension();
                $fileName = "tagihan_{$siswa->id_siswa}_{$idHasilTagihan}.{$extension}";
                $storedPath = $file->storeAs('public/tagihan_siswa', $fileName);
                $filePath = str_replace('public/', 'storage/', $storedPath);

            }

            if (!$filePath) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File tagihan gagal diunggah.',
                ], 400);
            }


            $hasilTagihan = HasilTagihan::create([
                'id_hasil_tagihan' => $idHasilTagihan,
                'id_siswa' => $siswa->id_siswa,
                'id_user' => $idUser,
                'nama_siswa' => $siswa->nama_siswa,
                'level' => $siswa->level,
                'akademik' => $siswa->akademik,
                'file_tagihan' => $filePath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Hasil tagihan berhasil disimpan.',
                'data' => $hasilTagihan
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
