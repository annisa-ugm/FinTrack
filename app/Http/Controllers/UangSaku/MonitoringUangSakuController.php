<?php

namespace App\Http\Controllers\UangSaku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\UangSaku;
use Illuminate\Support\Facades\Validator;

class MonitoringUangSakuController extends Controller
{
    // Fungsi index untuk semua siswa di page monitoring pendapatan praxis
    public function index()
    {
        $data = Siswa::with('uangSaku')
            ->orderBy('nama_siswa', 'asc')
            ->paginate(10);

        // Format nominal tagihan biar ada titik di setiap 3 angka
        $data->getCollection()->transform(function ($item) {
            if ($item->uangSaku) {
                $item->uangSaku->saldo = number_format($item->uangSaku->saldo ?? 0, 0, ',', '.');
            }
            return $item;
        });

        return response()->json($data);
    }

    public function show($id)
    {
        $siswa = Siswa::with('uangSaku')->find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json($siswa);
    }

    public function showUangSakuHistory($id)
    {
        $siswa = Siswa::with(['pembayaranUangSaku', 'pengeluaranUangSaku' => function ($query) {
            // $query->whereIn('jenis_pembayaran', ['Boarding', 'Konsumsi']);
        }])->find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json($siswa);
    }

}
