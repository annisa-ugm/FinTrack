<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Exception;

class SiswaController extends Controller
{
    public function searchSiswa(Request $request)
    {
        try {
            $query = $request->input('query');

            if (!$query) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Query kosong'
                ], 400);
            }

            $siswa = Siswa::where('nisn', 'like', "%$query%")
                ->orWhere('nama_siswa', 'like', "%$query%")
                ->take(10)
                ->get(['id_siswa', 'nisn', 'nama_siswa', 'level', 'akademik']);

            return response()->json([
                'status' => 'success',
                'data' => $siswa
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mencari siswa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
