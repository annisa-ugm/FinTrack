<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Validator;

class MonitoringPengeluaranController extends Controller
{
    public function index()
    {
        $data = Pengeluaran::with('jenisPengeluaran')
            ->orderBy('updated_at')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) {
            if ($item->total_pengeluaran) {
                $item->total_pengeluaran = number_format($item->total_pengeluaran ?? 0, 0, ',', '.');
            }
            return $item;
        });

        return response()->json($data);
    }

    public function detailPengeluaran($id)
    {
        $pengeluaran = Pengeluaran::with('subPengeluaran')->find($id);

        if (!$pengeluaran) {
            return response()->json(['message' => 'Pengeluaran tidak ditemukan'], 404);
        }

        return response()->json($pengeluaran);
    }
}
