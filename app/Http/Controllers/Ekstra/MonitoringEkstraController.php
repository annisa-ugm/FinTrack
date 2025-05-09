<?php

namespace App\Http\Controllers\Ekstra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\EkstraSiswa;
use App\Models\Ekstra;
use App\Models\PembayaranEkstra;
use Illuminate\Support\Facades\Validator;

class MonitoringEkstraController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua siswa dengan relasi ekstra_siswa dan ekstra
        $siswaList = Siswa::with(['ekstraSiswa.ekstra'])
            ->whereHas('ekstraSiswa') // hanya siswa yang punya ekstra
            ->orderBy('nama_siswa', 'asc')
            ->paginate(10);

        $siswaList->getCollection()->transform(function ($siswa) {
            return [
                'id_siswa' => $siswa->id_siswa,
                'nama_siswa' => $siswa->nama_siswa,
                'level' => $siswa->level,
                'ekstra' => $siswa->ekstraSiswa->map(function ($ekstraSiswa) {
                    return [
                        'id_ekstra_siswa' => $ekstraSiswa->id_ekstra_siswa,
                        'id_ekstra' => $ekstraSiswa->id_ekstra,
                        'nama_ekstra' => $ekstraSiswa->ekstra->nama_ekstra ?? null,
                        'tagihan_ekstra' => $ekstraSiswa->tagihan_ekstra !== null
                            ? number_format($ekstraSiswa->tagihan_ekstra, 0, ',', '.')
                            : null
                    ];
                })
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $siswaList,
        ]);
    }



    // public function index()
    // {
    //     $data = Siswa::with('ekstra')
    //         ->orderBy('nama_siswa', 'asc')
    //         ->paginate(10);

    //     // Format nominal tagihan biar ada titik di setiap 3 angka
    //     $data->getCollection()->transform(function ($item) {
    //         if ($item->ekstra) {
    //             $item->ekstra->tagihan_ekstra = number_format($item->ekstra->tagihan_ekstra ?? 0, 0, ',', '.');
    //         }
    //         return $item;
    //     });

    //     return response()->json($data);
    // }

    public function show($id)
    {
        // Cari data ekstra_siswa berdasarkan id_ekstra_siswa
        $ekstraSiswa = EkstraSiswa::with(['siswa', 'ekstra'])
            ->where('id_ekstra_siswa', $id)
            ->first();

        if (!$ekstraSiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data ekstra siswa tidak ditemukan.'
            ], 404);
        }

        $data = [
            'id_siswa' => $ekstraSiswa->siswa->id_siswa,
            'nama_siswa' => $ekstraSiswa->siswa->nama_siswa,
            'nisn' => $ekstraSiswa->siswa->nisn,
            'level' => $ekstraSiswa->siswa->level,
            'akademik' => $ekstraSiswa->siswa->akademik,
            'id_ekstra_siswa' => $ekstraSiswa->id_ekstra_siswa,
            'id_ekstra' => $ekstraSiswa->id_ekstra,
            'nama_ekstra' => $ekstraSiswa->ekstra->nama_ekstra ?? null,
            'tagihan_ekstra' => $ekstraSiswa->tagihan_ekstra !== null
                ? number_format($ekstraSiswa->tagihan_ekstra, 0, ',', '.')
                : null,
            'catatan' => $ekstraSiswa->catatan,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }


    public function showPaymentHistory($id)
    {
        $ekstraSiswa = EkstraSiswa::with(['pembayaranEkstra' => function ($query) {
        }])->find($id);

        if (!$ekstraSiswa) {
            return response()->json(['message' => 'Ekstra yang diikuti siswa tidak ditemukan'], 404);
        }

        return response()->json($ekstraSiswa);
    }

}
