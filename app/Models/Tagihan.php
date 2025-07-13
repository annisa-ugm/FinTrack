<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tagihan',
        'id_siswa',
        'tagihan_uang_kbm',
        'tagihan_uang_spp',
        'tagihan_uang_pemeliharaan',
        'tagihan_uang_sumbangan',
    ];

    /**
     * Relasi ke tabel siswa (Many to One).
     * Satu tagihan hanya untuk satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_tagihan AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_tagihan + 1) : '1';
    }

}
