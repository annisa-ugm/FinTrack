<?php

namespace App\Http\Controllers\UangSaku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\UangSaku;
use Illuminate\Support\Facades\Validator;

class MonitoringUangSakuController extends Controller
{
    public function index()
    {
        $data = Siswa::with('uangSaku')
            ->orderBy('nama_siswa', 'asc')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) {
            $tagihan = [];

            if ($item->uangSaku && $item->uangSaku->saldo < 0) {
                $tagihan[] = [
                    'nama_tagihan' => 'Uang Saku',
                    'nominal' => abs($item->uangSaku->saldo)
                ];
            }

            return [
                'id_siswa' => $item->id_siswa,
                'nama_siswa' => $item->nama_siswa,
                'nisn' => $item->nisn,
                'level' => $item->level,
                // 'kategori' => $item->kategori,
                'akademik' => $item->akademik,
                // 'nama_wali' => $item->nama_wali,
                // 'no_hp_wali' => $item->no_hp_wali,
                // 'created_at' => $item->created_at,
                // 'updated_at' => $item->updated_at,
                'tagihan' => $tagihan,
                'uang_saku' => $item->uangSaku ? [
                    'id_uang_saku' => $item->uangSaku->id_uang_saku,
                    'id_siswa' => $item->uangSaku->id_siswa,
                    'saldo' => number_format($item->uangSaku->saldo ?? 0, 0, ',', '.'),
                    'catatan' => $item->uangSaku->catatan,
                    'created_at' => $item->uangSaku->created_at,
                    'updated_at' => $item->uangSaku->updated_at,
                ] : null
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
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
