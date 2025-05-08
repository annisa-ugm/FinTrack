<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPengeluaran;
use App\Models\JenisPengeluaran;
use Illuminate\Support\Facades\Validator;

class KategoriPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');

        $query = KategoriPengeluaran::with('jenisPengeluaran');

        if ($type) {
            $query->whereHas('jenisPengeluaran', function ($q) use ($type) {
                $q->whereRaw('LOWER(nama_jenis_pengeluaran) = ?', [strtolower($type)]);
            });
        }

        $data = $query->get();

        return response()->json($data);
    }


    public function createKategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_pengeluaran' => 'required|string|max:255',
            'nama_kategori_pengeluaran' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid. Silakan periksa kembali.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $jenis = JenisPengeluaran::where('nama_jenis_pengeluaran', $request->jenis_pengeluaran)->first();

            if (!$jenis) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jenis pengeluaran tidak ditemukan.'
                ], 404);
            }

            $idJenisPengeluaran = $jenis->id_jenis_pengeluaran;

            $idKategoriPengeluaran = KategoriPengeluaran::generateId();
            $kategoriPengeluaran = KategoriPengeluaran::create([
                'id_kategori_pengeluaran' => $idKategoriPengeluaran,
                'id_jenis_pengeluaran' => $idJenisPengeluaran,
                'nama_kategori_pengeluaran' => $request->nama_kategori_pengeluaran,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kategori pengeluaran berhasil disimpan.',
                'data' => $kategoriPengeluaran
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    // public function getAllEkstra()
    // {
    //     $ekstraList = Ekstra::all(['id_ekstra', 'nama_ekstra', 'harga_ekstra']);

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $ekstraList
    //     ]);
    // }

}
