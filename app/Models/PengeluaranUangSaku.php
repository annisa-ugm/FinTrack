<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranUangSaku extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_uang_saku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengeluaran_uang_saku',
        'id_siswa',
        'id_user',
        'nominal',
        'tanggal_pengeluaran',
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
        $last = self::orderByRaw('CAST(id_pengeluaran_uang_saku AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pengeluaran_uang_saku + 1) : '1';
    }
}
