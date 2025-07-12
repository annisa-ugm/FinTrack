<?php

namespace App\Http\Controllers\Tunggakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Tunggakan;
use Illuminate\Support\Facades\Validator;

class TunggakanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|string',
            'nama_siswa' => 'required|string',
            'jenis_tagihan' => 'required|string',
            'periode' => 'required|string',
            'tagihan' => 'required|array|min:1',
            'tagihan.*.nama_tagihan' => 'required|string',
            'tagihan.*.nominal' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $nisn = Siswa::where('id_siswa', $request->id_siswa)->value('nisn');

        foreach ($request->tagihan as $tagihan) {
            $idTunggakan = Tunggakan::generateId();

            Tunggakan::create([
                'id_tunggakan' => $idTunggakan,
                'nisn' => $nisn,
                'nama_siswa' => $request->nama_siswa,
                'jenis_tagihan' => $request->jenis_tagihan,
                'nama_tagihan' => $tagihan['nama_tagihan'],
                'nominal' => $tagihan['nominal'],
                'periode' => $request->periode
            ]);
        }

        $this->resetTagihanAsal($request->id_siswa, $request->jenis_tagihan);

        return response()->json([
            'status' => 'success',
            'message' => 'Tunggakan berhasil ditambahkan'
        ]);
    }

    private function resetTagihanAsal($id_siswa, $jenis_tagihan)
    {
        switch (strtolower($jenis_tagihan)) {
            case 'boarding & konsumsi':
                // Reset boarding
                \DB::table('boarding_siswa')
                    ->where('id_siswa', $id_siswa)
                    ->update(['tagihan_boarding' => 0]);

                // Reset konsumsi
                \DB::table('konsumsi_siswa')
                    ->where('id_siswa', $id_siswa)
                    ->update(['tagihan_konsumsi' => 0]);
                break;

            case 'ekstra':
                \DB::table('ekstra_siswa')
                    ->where('id_siswa', $id_siswa)
                    ->update(['tagihan_ekstra' => 0]);
                break;

            case 'uang saku':
                \DB::table('uang_saku')
                    ->where('id_siswa', $id_siswa)
                    ->update(['saldo' => 0]);
                break;

            case 'umum':
                \DB::table('tagihan')
                    ->where('id_siswa', $id_siswa)
                    ->update([
                        'tagihan_uang_spp' => 0,
                        'tagihan_uang_kbm' => 0,
                        'tagihan_uang_pemeliharaan' => 0,
                        'tagihan_uang_sumbangan' => 0
                    ]);
                break;
        }
    }

    // List semua tunggakan
    public function index()
    {
        $data = Tunggakan::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Update status tunggakan (misalnya jadi Lunas)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Lunas,Belum Lunas',
        ]);

        $tunggakan = Tunggakan::findOrFail($id);
        $tunggakan->status = $request->status;
        $tunggakan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status tunggakan diperbarui.',
            'data' => $tunggakan
        ]);
    }

}
