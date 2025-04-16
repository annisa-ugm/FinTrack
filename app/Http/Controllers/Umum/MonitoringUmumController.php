<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class MonitoringUmumController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data siswa dan tagihan (left join)
        $data = Siswa::leftJoin('tagihan', 'siswa.id_siswa', '=', 'tagihan.id_siswa')
            ->select(
                'siswa.nama_siswa',
                'siswa.nisn',
                'siswa.level',
                'siswa.akademik',
                'tagihan.tagihan_uang_kbm',
                'tagihan.tagihan_uang_spp',
                'tagihan.tagihan_uang_pemeliharaan',
                'tagihan.tagihan_uang_sumbangan'
            )
            ->orderBy('siswa.nama_siswa', 'asc')
            ->paginate(10); // Ubah jumlah per halaman sesuai kebutuhan

        // Format angka rupiah agar lebih mudah dibaca
        $data->getCollection()->transform(function ($item) {
            $item->tagihan_uang_kbm = $item->tagihan_uang_kbm !== null ? number_format($item->tagihan_uang_kbm, 0, ',', '.') : null;
            $item->tagihan_uang_spp = $item->tagihan_uang_spp !== null ? number_format($item->tagihan_uang_spp, 0, ',', '.') : null;
            $item->tagihan_uang_pemeliharaan = $item->tagihan_uang_pemeliharaan !== null ? number_format($item->tagihan_uang_pemeliharaan, 0, ',', '.') : null;
            $item->tagihan_uang_sumbangan = $item->tagihan_uang_sumbangan !== null ? number_format($item->tagihan_uang_sumbangan, 0, ',', '.') : null;
            return $item;
        });

        return response()->json($data);

    }

}
