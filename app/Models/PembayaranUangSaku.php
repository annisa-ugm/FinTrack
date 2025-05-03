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
        'id_user',
        'nominal',
        'tanggal_pembayaran',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pembayaran_uang_saku AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pembayaran_uang_saku + 1) : '1';
    }
}
