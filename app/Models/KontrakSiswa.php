<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakSiswa extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'kontrak_siswa';

    // Menonaktifkan auto-increment karena id_kontrak_siswa adalah string
    public $incrementing = false;

    // Menentukan tipe primary key sebagai string
    protected $keyType = 'string';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_kontrak_siswa',
        'id_siswa',
        'uang_kbm',
        'uang_spp',
        'uang_pemeliharaan',
        'uang_konsumsi',
        'uang_boarding',
        'uang_sumbangan',
        'catatan',
    ];

    /**
     * Relasi ke tabel siswa (Many to One).
     * Satu kontrak hanya untuk satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_kontrak_siswa AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_kontrak_siswa + 1) : '1';
    }

}
