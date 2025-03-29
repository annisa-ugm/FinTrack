<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkstraSiswa extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'ekstra_siswa';

    // Menonaktifkan auto-increment karena id_ekstra_siswa adalah string
    public $incrementing = false;

    // Menentukan tipe primary key sebagai string
    protected $keyType = 'string';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_ekstra_siswa',
        'id_siswa',
        'id_ekstra',
        'kontrak_ekstra',
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
}
