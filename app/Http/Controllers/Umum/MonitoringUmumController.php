<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Tagihan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class MonitoringUmumController extends Controller
{
    // Fungsi index untuk semua siswa di page monitoring pendapatan praxis
    public function indexPraxis()
    {
        $data = Siswa::with('tagihan')
            ->where('akademik', 'Praxis')
            ->orderBy('nama_siswa', 'asc')
            ->paginate(10);

        // Format nominal tagihan biar ada titik di setiap 3 angka
        $data->getCollection()->transform(function ($item) {
            if ($item->tagihan) {
                $item->tagihan->tagihan_uang_kbm = number_format($item->tagihan->tagihan_uang_kbm ?? 0, 0, ',', '.');
                $item->tagihan->tagihan_uang_spp = number_format($item->tagihan->tagihan_uang_spp ?? 0, 0, ',', '.');
                $item->tagihan->tagihan_uang_pemeliharaan = number_format($item->tagihan->tagihan_uang_pemeliharaan ?? 0, 0, ',', '.');
                $item->tagihan->tagihan_uang_sumbangan = number_format($item->tagihan->tagihan_uang_sumbangan ?? 0, 0, ',', '.');
            }
            return $item;
        });

        return response()->json($data);
    }

    public function indexTechno()
    {
        $data = Siswa::with('tagihan')
            ->where('akademik', 'Techno')
            ->orderBy('nama_siswa', 'asc')
            ->paginate(10);

        // Format nominal tagihan biar ada titik di setiap 3 angka
        $data->getCollection()->transform(function ($item) {
            if ($item->tagihan) {
                $item->tagihan->tagihan_uang_kbm = number_format($item->tagihan->tagihan_uang_kbm ?? 0, 0, ',', '.');
                $item->tagihan->tagihan_uang_spp = number_format($item->tagihan->tagihan_uang_spp ?? 0, 0, ',', '.');
                $item->tagihan->tagihan_uang_pemeliharaan = number_format($item->tagihan->tagihan_uang_pemeliharaan ?? 0, 0, ',', '.');
                $item->tagihan->tagihan_uang_sumbangan = number_format($item->tagihan->tagihan_uang_sumbangan ?? 0, 0, ',', '.');
            }
            return $item;
        });

        return response()->json($data);
    }

    public function showKontrak($id)
    {
        // Ambil siswa dan kontraknya saja (gapake tagihan)
        $siswa = Siswa::with('kontrak')->find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json($siswa);
    }

    public function show($id)
    {
        $siswa = Siswa::with('kontrak')->find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json($siswa);
    }


}
