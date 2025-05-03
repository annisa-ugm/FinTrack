<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkstraSiswa extends Model
{
    use HasFactory;

    protected $table = 'ekstra_siswa';
    protected $primaryKey = 'id_ekstra_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ekstra_siswa',
        'id_siswa',
        'id_ekstra',
        'tanggal_mulai',
        'tanggal_selesai',
        'tagihan_ekstra',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // Relasi dengan tabel Ekstra
    public function ekstra()
    {
        return $this->belongsTo(Ekstra::class, 'id_ekstra', 'id_ekstra');
    }

    public function pembayaranEkstra()
    {
        return $this->hasMany(PembayaranEkstra::class, 'id_ekstra_siswa', 'id_ekstra_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_ekstra_siswa AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_ekstra_siswa + 1) : '1';
    }
}
