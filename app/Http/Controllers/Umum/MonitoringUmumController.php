<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class MonitoringUmumController extends Controller
{
    public function indexPraxis()
    {
        try {
            $data = Siswa::with('tagihan')
                ->where('akademik', 'Praxis')
                ->orderBy('nama_siswa', 'asc')
                ->paginate(10);

            $data->getCollection()->transform(function ($item) {
                $tagihanList = [];

                if ($item->tagihan) {
                    $spp = (int) ($item->tagihan->tagihan_uang_spp ?? 0);
                    if ($spp > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'SPP',
                            'nominal' => $spp
                        ];
                    }

                    $kbm = (int) ($item->tagihan->tagihan_uang_kbm ?? 0);
                    if ($kbm > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'KBM',
                            'nominal' => $kbm
                        ];
                    }

                    $pemeliharaan = (int) ($item->tagihan->tagihan_uang_pemeliharaan ?? 0);
                    if ($pemeliharaan > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'Pemeliharaan',
                            'nominal' => $pemeliharaan
                        ];
                    }

                    $sumbangan = (int) ($item->tagihan->tagihan_uang_sumbangan ?? 0);
                    if ($sumbangan > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'Sumbangan',
                            'nominal' => $sumbangan
                        ];
                    }
                }

                return [
                    'id_siswa' => $item->id_siswa,
                    'nama_siswa' => $item->nama_siswa,
                    'level' => $item->level,
                    'tagihan' => $tagihanList
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa Praxis berhasil diambil',
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function indexTechno()
    {
        try {
            $data = Siswa::with('tagihan')
                ->where('akademik', 'Techno')
                ->orderBy('nama_siswa', 'asc')
                ->paginate(10);

            $data->getCollection()->transform(function ($item) {
                $tagihanList = [];

                if ($item->tagihan) {
                    $spp = (int) ($item->tagihan->tagihan_uang_spp ?? 0);
                    if ($spp > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'SPP',
                            'nominal' => $spp
                        ];
                    }

                    $kbm = (int) ($item->tagihan->tagihan_uang_kbm ?? 0);
                    if ($kbm > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'KBM',
                            'nominal' => $kbm
                        ];
                    }

                    $pemeliharaan = (int) ($item->tagihan->tagihan_uang_pemeliharaan ?? 0);
                    if ($pemeliharaan > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'Pemeliharaan',
                            'nominal' => $pemeliharaan
                        ];
                    }

                    $sumbangan = (int) ($item->tagihan->tagihan_uang_sumbangan ?? 0);
                    if ($sumbangan > 0) {
                        $tagihanList[] = [
                            'nama_tagihan' => 'Sumbangan',
                            'nominal' => $sumbangan
                        ];
                    }
                }

                return [
                    'id_siswa' => $item->id_siswa,
                    'nama_siswa' => $item->nama_siswa,
                    'level' => $item->level,
                    'tagihan' => $tagihanList
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa Techno berhasil diambil',
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function indexPraxis()
    // {
    //     try {
    //         $data = Siswa::with('tagihan')
    //             ->where('akademik', 'Praxis')
    //             ->orderBy('nama_siswa', 'asc')
    //             ->paginate(10);

    //         $data->getCollection()->transform(function ($item) {
    //             if ($item->tagihan) {
    //                 $item->tagihan->tagihan_uang_kbm = number_format($item->tagihan->tagihan_uang_kbm ?? 0, 0, ',', '.');
    //                 $item->tagihan->tagihan_uang_spp = number_format($item->tagihan->tagihan_uang_spp ?? 0, 0, ',', '.');
    //                 $item->tagihan->tagihan_uang_pemeliharaan = number_format($item->tagihan->tagihan_uang_pemeliharaan ?? 0, 0, ',', '.');
    //                 $item->tagihan->tagihan_uang_sumbangan = number_format($item->tagihan->tagihan_uang_sumbangan ?? 0, 0, ',', '.');
    //             }
    //             return $item;
    //         });

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Data siswa Praxis berhasil diambil',
    //             'data' => $data
    //         ]);

    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan saat mengambil data',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function indexTechno()
    // {
    //     try {
    //         $data = Siswa::with('tagihan')
    //         ->where('akademik', 'Techno')
    //         ->orderBy('nama_siswa', 'asc')
    //         ->paginate(10);

    //         $data->getCollection()->transform(function ($item) {
    //             if ($item->tagihan) {
    //                 $item->tagihan->tagihan_uang_kbm = number_format($item->tagihan->tagihan_uang_kbm ?? 0, 0, ',', '.');
    //                 $item->tagihan->tagihan_uang_spp = number_format($item->tagihan->tagihan_uang_spp ?? 0, 0, ',', '.');
    //                 $item->tagihan->tagihan_uang_pemeliharaan = number_format($item->tagihan->tagihan_uang_pemeliharaan ?? 0, 0, ',', '.');
    //                 $item->tagihan->tagihan_uang_sumbangan = number_format($item->tagihan->tagihan_uang_sumbangan ?? 0, 0, ',', '.');
    //             }
    //             return $item;
    //         });

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Data siswa Techno berhasil diambil',
    //             'data' => $data
    //         ]);

    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan saat mengambil data',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function showKontrak($id)
    {
        try {
            $siswa = Siswa::with('kontrak')->find($id);

            if (!$siswa) {
                return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil diambil',
                'data' => $siswa
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data siswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $siswa = Siswa::with('kontrak')->find($id);

            if (!$siswa) {
                return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil diambil',
                'data' => $siswa
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data siswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
