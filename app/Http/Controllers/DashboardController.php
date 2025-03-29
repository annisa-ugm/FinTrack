<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\PembayaranEkstra;
use App\Models\EkstraSiswa;
use App\Models\UangSaku;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total saldo berdasarkan akademik siswa
        $saldoPraxis = Pembayaran::whereHas('siswa', function ($query) {
            $query->where('akademik', 'Praxis');
        })->sum('nominal');

        $saldoTechno = Pembayaran::whereHas('siswa', function ($query) {
            $query->where('akademik', 'Techno');
        })->sum('nominal');

        // Ambil total tagihan berdasarkan akademik siswa
        $tagihanPraxis = Tagihan::whereHas('siswa', function ($query) {
            $query->where('akademik', 'Praxis');
        })->sum(\DB::raw('tagihan_uang_kbm + tagihan_uang_spp + tagihan_uang_pemeliharaan + tagihan_uang_konsumsi + tagihan_uang_boarding + tagihan_uang_sumbangan'));

        $tagihanTechno = Tagihan::whereHas('siswa', function ($query) {
            $query->where('akademik', 'Techno');
        })->sum(\DB::raw('tagihan_uang_kbm + tagihan_uang_spp + tagihan_uang_pemeliharaan + tagihan_uang_konsumsi + tagihan_uang_boarding + tagihan_uang_sumbangan'));

        // Ambil total saldo ekstra
        $saldoEkstra = PembayaranEkstra::sum('nominal');

        // Ambil total tagihan ekstra
        $tagihanEkstra = EkstraSiswa::sum('tagihan_ekstra');

        // Ambil total tagihan uang saku (hanya saldo negatif)
        $tagihanUangSaku = UangSaku::where('saldo', '<', 0)->sum(\DB::raw('ABS(saldo)'));

        $rekapSaldo = $saldoPraxis + $saldoTechno + $saldoEkstra;
        $rekapTagihan = $tagihanPraxis + $tagihanTechno + $tagihanEkstra + $tagihanUangSaku;

        return response()->json([
            'saldoPraxis' => $saldoPraxis,
            'saldoTechno' => $saldoTechno,
            'tagihanPraxis' => $tagihanPraxis,
            'tagihanTechno' => $tagihanTechno,

            'saldoEkstra' => $saldoEkstra,
            'tagihanEkstra' => $tagihanEkstra,

            'tagihanUangSaku' => $tagihanUangSaku,
            'rekapSaldo' => $rekapSaldo,
            'rekapTagihan' => $rekapTagihan
        ]);
    }
}
