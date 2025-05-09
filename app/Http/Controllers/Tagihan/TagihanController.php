<?php

namespace App\Http\Controllers\Tagihan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class TagihanController extends Controller
{
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

}
