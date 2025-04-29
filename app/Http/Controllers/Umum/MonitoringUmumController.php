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

    // public function index(Request $request)
    // {
    //     // Ambil data siswa dan tagihan (left join)
    //     $data = Siswa::leftJoin('tagihan', 'siswa.id_siswa', '=', 'tagihan.id_siswa')
    //         ->select(
    //             'siswa.nama_siswa',
    //             'siswa.nisn',
    //             'siswa.level',
    //             'siswa.akademik',
    //             'tagihan.tagihan_uang_kbm',
    //             'tagihan.tagihan_uang_spp',
    //             'tagihan.tagihan_uang_pemeliharaan',
    //             'tagihan.tagihan_uang_sumbangan'
    //         )
    //         ->orderBy('siswa.nama_siswa', 'asc')
    //         ->paginate(10); // Ubah jumlah per halaman sesuai kebutuhan

    //     // Format angka rupiah agar lebih mudah dibaca
    //     $data->getCollection()->transform(function ($item) {
    //         $item->tagihan_uang_kbm = $item->tagihan_uang_kbm !== null ? number_format($item->tagihan_uang_kbm, 0, ',', '.') : null;
    //         $item->tagihan_uang_spp = $item->tagihan_uang_spp !== null ? number_format($item->tagihan_uang_spp, 0, ',', '.') : null;
    //         $item->tagihan_uang_pemeliharaan = $item->tagihan_uang_pemeliharaan !== null ? number_format($item->tagihan_uang_pemeliharaan, 0, ',', '.') : null;
    //         $item->tagihan_uang_sumbangan = $item->tagihan_uang_sumbangan !== null ? number_format($item->tagihan_uang_sumbangan, 0, ',', '.') : null;
    //         return $item;
    //     });
    //     return response()->json($data);
    // }

    // public function index(Request $request)
    // {
    //     // Base query
    //     $query = Siswa::leftJoin('tagihan', 'siswa.id_siswa', '=', 'tagihan.id_siswa')
    //         ->select(
    //             'siswa.id_siswa',
    //             'siswa.nama_siswa',
    //             'siswa.nisn',
    //             'siswa.level',
    //             'siswa.akademik',
    //             'tagihan.tagihan_uang_kbm',
    //             'tagihan.tagihan_uang_spp',
    //             'tagihan.tagihan_uang_pemeliharaan',
    //             'tagihan.tagihan_uang_sumbangan'
    //         );

    //     // Filter berdasarkan ID siswa
    //     if ($request->has('id_siswa')) {
    //         $query->where('siswa.id_siswa', $request->id_siswa);
    //         $siswa = $query->first();

    //         if (!$siswa) {
    //             return response()->json(['message' => 'Data siswa tidak ditemukan'], 404);
    //         }

    //         return response()->json($this->formatTagihan($siswa));
    //     }

    //     // Filter berdasarkan NISN
    //     if ($request->has('nisn')) {
    //         $query->where('siswa.nisn', $request->nisn);
    //         $siswa = $query->first();

    //         if (!$siswa) {
    //             return response()->json(['message' => 'Data siswa tidak ditemukan'], 404);
    //         }

    //         return response()->json($this->formatTagihan($siswa));
    //     }

    //     // Kalau tidak ada filter, paginate
    //     $data = $query->orderBy('siswa.nama_siswa', 'asc')->paginate(10);

    //     // Format tagihan dalam koleksi
    //     $data->getCollection()->transform(function ($item) {
    //         return $this->formatTagihan($item);
    //     });

    //     return response()->json($data);
    // }

    // // Fungsi bantu untuk format tagihan
    // private function formatTagihan($item)
    // {
    //     $item->tagihan_uang_kbm = $item->tagihan_uang_kbm !== null ? number_format($item->tagihan_uang_kbm, 0, ',', '.') : null;
    //     $item->tagihan_uang_spp = $item->tagihan_uang_spp !== null ? number_format($item->tagihan_uang_spp, 0, ',', '.') : null;
    //     $item->tagihan_uang_pemeliharaan = $item->tagihan_uang_pemeliharaan !== null ? number_format($item->tagihan_uang_pemeliharaan, 0, ',', '.') : null;
    //     $item->tagihan_uang_sumbangan = $item->tagihan_uang_sumbangan !== null ? number_format($item->tagihan_uang_sumbangan, 0, ',', '.') : null;
    //     return $item;
    // }

}
