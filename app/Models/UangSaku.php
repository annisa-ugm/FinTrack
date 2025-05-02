<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangSaku extends Model
{
    use HasFactory;

    protected $table = 'uang_saku';
    protected $primaryKey = 'id_uang_saku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_uang_saku',
        'id_siswa',
        'saldo',
        // 'kontrak_uang_saku',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_uang_saku AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_uang_saku + 1) : '1';
    }
}
