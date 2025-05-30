<?php

namespace App\Http\Controllers\Ekstra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekstra;
use Illuminate\Support\Facades\Validator;

class EkstraController extends Controller
{
    public function index()
    {
        $data = Ekstra::query()->paginate(10);

        $data->getCollection()->transform(function ($item) {
            if ($item) {
                $item->biaya_ekstra = number_format($item->biaya_ekstra ?? 0, 0, ',', '.');
            }
            return $item;
        });

        return response()->json($data);
    }


    public function createEkstra(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ekstra' => 'required|string|max:255',
            'biaya_ekstra' => 'required|integer|regex:/^\d+$/',
        ], [
            'regex' => 'Kolom :attribute tidak boleh mengandung titik atau koma.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid. Silakan periksa kembali.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $idEkstra = Ekstra::generateId();
            $ekstra = Ekstra::create([
                'id_ekstra' => $idEkstra,
                'nama_ekstra' => $request->nama_ekstra,
                'biaya_ekstra' => $request->biaya_ekstra,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Esktra berhasil disimpan.',
                'data' => $ekstra
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllEkstra()
    {
        $ekstraList = Ekstra::all(['id_ekstra', 'nama_ekstra', 'biaya_ekstra']);

        return response()->json([
            'status' => 'success',
            'data' => $ekstraList
        ]);
    }

}
