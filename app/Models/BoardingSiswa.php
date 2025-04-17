<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingSiswa extends Model
{
    use HasFactory;

    protected $table = 'boarding_siswa';
    protected $primaryKey = 'id_boarding_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_boarding_siswa',
        'id_siswa',
        'tanggal_mulai',
        'tanggal_selesai',
        'tagihan_boarding',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_boarding_siswa AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_boarding_siswa + 1) : '1';
    }
}
