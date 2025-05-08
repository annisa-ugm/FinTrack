<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubPengeluaran;
use App\Models\Pengeluaran;
use App\Models\JenisPengeluaran;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TambahPengeluaranController extends Controller
{
    public function createPengeluaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_pengeluaran' => 'required|string|max:255',
            'nama_pengeluaran' => 'required|string|max:255',
            'sub_pengeluaran' => 'required|array|min:1',
            'sub_pengeluaran.*.id_kategori_pengeluaran' => 'required|string',
            'sub_pengeluaran.*.nama_sub_pengeluaran' => 'required|string|max:255',
            'sub_pengeluaran.*.nominal' => 'required|numeric|min:0',
            'sub_pengeluaran.*.jumlah_item' => 'required|integer|min:1',
            'sub_pengeluaran.*.tanggal_pengeluaran' => 'required|date',
            'sub_pengeluaran.*.file_nota' => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid. Silakan periksa kembali.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $jenis = JenisPengeluaran::where('nama_jenis_pengeluaran', $request->jenis_pengeluaran)->first();

            if (!$jenis) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jenis pengeluaran tidak ditemukan.'
                ], 404);
            }

            $idUser = auth()->user()->id_user;
            $idJenisPengeluaran = $jenis->id_jenis_pengeluaran;
            $idPengeluaran = Pengeluaran::generateId();

            // Hitung total pengeluaran di tabel pengeluaran (hasil sum total di tiap sub)
            $totalPengeluaran = 0;
            foreach ($request->sub_pengeluaran as $sub) {
                $totalPengeluaran += $sub['nominal'] * $sub['jumlah_item'];
            }

            $pengeluaran = Pengeluaran::create([
                'id_pengeluaran' => $idPengeluaran,
                'id_jenis_pengeluaran' => $idJenisPengeluaran,
                'id_user' => $idUser,
                'nama_pengeluaran' => $request->nama_pengeluaran,
                'total_pengeluaran' => $totalPengeluaran,
            ]);


            foreach ($request->sub_pengeluaran as $index => $sub) {
                $idSubPengeluaran = SubPengeluaran::generateId();

                $filePath = null;
                if ($request->hasFile("sub_pengeluaran.$index.file_nota")) {
                    $file = $request->file("sub_pengeluaran.$index.file_nota");
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "nota_{$idSubPengeluaran}." . $extension;
                    $storedPath = $file->storeAs('public/sub_pengeluaran', $fileName);
                    $filePath = str_replace('public/', 'storage/', $storedPath);
                }

                SubPengeluaran::create([
                    'id_sub_pengeluaran' => $idSubPengeluaran,
                    'id_pengeluaran' => $idPengeluaran,
                    'id_kategori_pengeluaran' => $sub['id_kategori_pengeluaran'],
                    'id_user' => $idUser,
                    'nama_sub_pengeluaran' => $sub['nama_sub_pengeluaran'],
                    'nominal' => $sub['nominal'],
                    'jumlah_item' => $sub['jumlah_item'],
                    'file_nota' => $filePath,
                    'tanggal_pengeluaran' => $sub['tanggal_pengeluaran'],
                ]);
            }


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pengeluaran dan sub pengeluaran berhasil disimpan.',
                'data' => $pengeluaran
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
