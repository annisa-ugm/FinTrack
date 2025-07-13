<?php

namespace App\Http\Controllers\Techno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaTechno;
use Exception;

class SiswaTechnoController extends Controller
{
    // Tambah siswa
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nisn' => 'required|string|max:20|unique:siswa_technos,nisn',
                'nama_siswa' => 'required|string|max:255',
                'kelas' => 'required|string|max:100',
                'email' => 'nullable|email',
            ]);

            $siswa = SiswaTechno::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Siswa berhasil ditambahkan',
                'data' => $siswa
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan siswa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Edit siswa
    public function update(Request $request, $id)
    {
        try {
            $siswa = SiswaTechno::findOrFail($id);

            $request->validate([
                'nisn' => 'required|string|max:20|unique:siswa_technos,nisn,' . $id . ',id_siswa',
                'nama_siswa' => 'required|string|max:255',
                'kelas' => 'required|string|max:100',
                'email' => 'nullable|email',
            ]);

            $siswa->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Siswa berhasil diperbarui',
                'data' => $siswa
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui siswa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Hapus siswa
    public function destroy($id)
    {
        try {
            $siswa = SiswaTechno::findOrFail($id);
            $siswa->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Siswa berhasil dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus siswa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
