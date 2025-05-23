<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilTagihan extends Model
{
    use HasFactory;

    protected $table = 'hasil_tagihan';
    protected $primaryKey = 'id_hasil_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_hasil_tagihan',
        'id_siswa',
        'id_user',
        'nama_siswa',
        'level',
        'akademik',
        'file_tagihan',
    ];

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
        $last = self::orderByRaw('CAST(id_hasil_tagihan AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_hasil_tagihan + 1) : '1';
    }
}
