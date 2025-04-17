<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranUangSaku extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_uang_saku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pembayaran_uang_saku',
        'id_siswa',
        'nominal',
        'kontrak_uang_saku',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pembayaran_uang_saku AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pembayaran_uang_saku + 1) : '1';
    }
}
