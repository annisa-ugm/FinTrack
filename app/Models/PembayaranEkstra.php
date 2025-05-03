<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranEkstra extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_ekstra';
    protected $primaryKey = 'id_pembayaran_ekstra';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pembayaran_ekstra',
        'id_siswa',
        'id_user',
        'id_ekstra_siswa',
        'tanggal_pembayaran',
        'nominal',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function user()
    {
        return $this->belongsTo(Siswa::class, 'id_user', 'id_user');
    }

    // Relasi dengan tabel Ekstra
    public function ekstraSiswa()
    {
        return $this->belongsTo(EkstraSiswa::class, 'id_ekstra_siswa', 'id_ekstra_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pembayaran_ekstra AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pembayaran_ekstra + 1) : '1';
    }
}
