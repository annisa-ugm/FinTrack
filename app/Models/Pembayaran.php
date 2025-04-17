<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pembayaran',
        'id_siswa',
        'id_user',
        'tanggal_pembayaran',
        'jenis_pembayaran',
        'nominal',
        'catatan',
    ];

    /**
     * Relasi ke tabel siswa (Many to One).
     * Satu pembayaran hanya dimiliki oleh satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Relasi ke tabel users (Many to One).
     * Satu pembayaran dilakukan oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pembayaran AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pembayaran + 1) : '1';
    }
}
