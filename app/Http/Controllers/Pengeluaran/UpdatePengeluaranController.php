<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\SubPengeluaran;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdatePengeluaranController extends Controller
{
    public function updatePengeluaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengeluaran' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengeluaran = Pengeluaran::find($id);
        if (!$pengeluaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengeluaran tidak ditemukan.'
            ], 404);
        }

        $pengeluaran->nama_pengeluaran = $request->nama_pengeluaran;
        $pengeluaran->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengeluaran berhasil diperbarui.',
            'data' => $pengeluaran
        ]);
    }

    public function updateSubPengeluaran(Request $request, $id)
    {
        \Log::info($request->all());

        $validator = Validator::make($request->all(), [
            'id_kategori_pengeluaran' => 'required|string',
            'nama_sub_pengeluaran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'jumlah_item' => 'required|integer|min:1',
            'tanggal_pengeluaran' => 'required|date',
            'file_nota' => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $subPengeluaran = SubPengeluaran::find($id);
        if (!$subPengeluaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sub pengeluaran tidak ditemukan.'
            ], 404);
        }

        // Jika ada file baru, simpan dan hapus file lama
        if ($request->hasFile('file_nota')) {
            // Hapus file lama kalau ada
            if ($subPengeluaran->file_nota && Storage::exists(str_replace('storage/', 'public/', $subPengeluaran->file_nota))) {
                Storage::delete(str_replace('storage/', 'public/', $subPengeluaran->file_nota));
            }

            $file = $request->file('file_nota');
            $extension = $file->getClientOriginalExtension();
            $fileName = "nota_{$id}." . $extension;
            $storedPath = $file->storeAs('public/sub_pengeluaran', $fileName);
            $filePath = str_replace('public/', 'storage/', $storedPath);

            $subPengeluaran->file_nota = $filePath;
        }

        $subPengeluaran->id_kategori_pengeluaran = $request->id_kategori_pengeluaran;
        $subPengeluaran->nama_sub_pengeluaran = $request->nama_sub_pengeluaran;
        $subPengeluaran->nominal = $request->nominal;
        $subPengeluaran->jumlah_item = $request->jumlah_item;
        $subPengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;

        $subPengeluaran->save();

        // Update total pengeluaran utama di tabel pengeluaran juga
        $pengeluaran = Pengeluaran::find($subPengeluaran->id_pengeluaran);
        if ($pengeluaran) {
            $total = $pengeluaran->subPengeluaran->sum(function ($item) {
                return $item->nominal * $item->jumlah_item;
            });
            $pengeluaran->total_pengeluaran = $total;
            $pengeluaran->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sub pengeluaran berhasil diperbarui.',
            'data' => $subPengeluaran
        ]);
    }

    public function deleteSubPengeluaran($id)
    {
        $subPengeluaran = SubPengeluaran::find($id);

        if (!$subPengeluaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sub pengeluaran tidak ditemukan.'
            ], 404);
        }

        // Hapus file nota kalau ada
        if ($subPengeluaran->file_nota && Storage::exists(str_replace('storage/', 'public/', $subPengeluaran->file_nota))) {
            Storage::delete(str_replace('storage/', 'public/', $subPengeluaran->file_nota));
        }

        $idPengeluaran = $subPengeluaran->id_pengeluaran;
        $subPengeluaran->delete();

        // Sinkronisasi total di tabel pengeluaran
        $pengeluaran = Pengeluaran::find($idPengeluaran);
        if ($pengeluaran) {
            $total = $pengeluaran->subPengeluaran->sum(function ($item) {
                return $item->nominal * $item->jumlah_item;
            });
            $pengeluaran->total_pengeluaran = $total;
            $pengeluaran->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sub pengeluaran berhasil dihapus.'
        ]);
    }

}
