<?php

namespace App\Http\Controllers\BoardingKonsumsi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class MonitoringBKController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data siswa dan tagihan boarding + konsumsi (left join)
        $siswa = Siswa::leftJoin('boarding_siswa', 'siswa.id_siswa', '=', 'boarding_siswa.id_siswa')
            ->leftJoin('konsumsi_siswa', 'siswa.id_siswa', '=', 'konsumsi_siswa.id_siswa')
            ->select(
                'siswa.id_siswa',
                'siswa.nama_siswa',
                'siswa.level',
                'siswa.akademik',
                \DB::raw('MAX(boarding_siswa.tagihan_boarding) as tagihan_boarding'),
                \DB::raw('MAX(konsumsi_siswa.tagihan_konsumsi) as tagihan_konsumsi')
            )
            ->where(function ($query) {
                $query->whereNotNull('boarding_siswa.id_siswa')
                      ->orWhereNotNull('konsumsi_siswa.id_siswa');
            })
            ->groupBy('siswa.id_siswa', 'siswa.nama_siswa', 'siswa.level', 'siswa.akademik')
            ->orderBy('siswa.nama_siswa', 'asc')
            ->paginate(10);

        $siswa->getCollection()->transform(function ($item) {
            $item->tagihan_boarding = $item->tagihan_boarding !== null ? number_format($item->tagihan_boarding, 0, ',', '.') : null;
            $item->tagihan_konsumsi = $item->tagihan_konsumsi !== null ? number_format($item->tagihan_konsumsi, 0, ',', '.') : null;
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data' => $siswa,
        ]);
    }

    public function show($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json($siswa);
    }

    public function showPaymentHistory($id)
    {
        $siswa = Siswa::with(['pembayaran' => function ($query) {
            $query->whereIn('jenis_pembayaran', ['Boarding', 'Konsumsi']);
        }])->find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json($siswa);
    }

}
