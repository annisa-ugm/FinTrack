<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Exception;

class SiswaTechnoController extends Controller
{
    // Tampilkan daftar siswa Techno
    public function index()
    {
        try {
            $siswa = Siswa::where('akademik', 'Techno')
                        ->orderBy('nama_siswa', 'asc')
                        ->paginate(10);

            return response()->json([
                'status' => 'success',
                'data' => $siswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data siswa Techno.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Tambah siswa
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nisn' => 'required|string|max:255|unique:siswa,nisn',
                'nama_siswa' => 'required|string|max:255',
                'level' => 'nullable|string|max:20',
                'kategori' => 'nullable|string|max:20',
                'nama_wali' => 'required|string|max:255',
                'no_hp_wali' => 'required|string|max:255',
            ]);

            $siswa = Siswa::create([
                'id_siswa' => Siswa::generateId(),
                'nisn' => $request->nisn,
                'nama_siswa' => $request->nama_siswa,
                'level' => $request->level,
                'kategori' => $request->kategori,
                'akademik' => 'Techno', // Hardcoded
                'nama_wali' => $request->nama_wali,
                'no_hp_wali' => $request->no_hp_wali,
            ]);

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

    // Tampilkan detail satu siswa
    public function show($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            // Hanya siswa dengan akademik = 'Techno' yang bisa ditampilkan
            if (strtolower($siswa->akademik) !== 'techno') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data bukan siswa Techno.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $siswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menampilkan detail siswa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Edit siswa
    public function update(Request $request, $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $request->validate([
                'nisn' => 'required|string|max:255|unique:siswa,nisn,' . $id . ',id_siswa',
                'nama_siswa' => 'required|string|max:255',
                'level' => 'nullable|string|max:20',
                'kategori' => 'nullable|string|max:20',
                'nama_wali' => 'required|string|max:255',
                'no_hp_wali' => 'required|string|max:255',
            ]);

            $siswa->update([
                'nisn' => $request->nisn,
                'nama_siswa' => $request->nama_siswa,
                'level' => $request->level,
                'kategori' => $request->kategori,
                'akademik' => 'Techno', // Tetap hardcoded
                'nama_wali' => $request->nama_wali,
                'no_hp_wali' => $request->no_hp_wali,
            ]);

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
            $siswa = Siswa::findOrFail($id);
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
