<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranEkstra extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'pembayaran_ekstra';

    // Menonaktifkan auto-increment karena id_pembayaran_ekstra adalah string
    public $incrementing = false;

    // Menentukan tipe primary key sebagai string
    protected $keyType = 'string';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_pembayaran_ekstra',
        'id_siswa',
        'id_ekstra',
        'nominal',
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
}
