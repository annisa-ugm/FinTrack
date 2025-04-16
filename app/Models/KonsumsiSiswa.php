<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsumsiSiswa extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'konsumsi_siswa';

    // Menonaktifkan auto-increment karena id_ekstra_siswa adalah string
    public $incrementing = false;

    // Menentukan tipe primary key sebagai string
    protected $keyType = 'string';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_konsumsi_siswa',
        'id_siswa',
        'tanggal_mulai',
        'tanggal_selesai',
        'tagihan_konsumsi',
        'catatan',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_konsumsi_siswa AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_konsumsi_siswa + 1) : '1';
    }
}
