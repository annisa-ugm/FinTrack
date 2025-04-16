<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranUangSaku extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'pengeluaran_uang_saku';

    // Menonaktifkan auto-increment karena id_pengeluaran_uang_saku adalah string
    public $incrementing = false;

    // Menentukan tipe primary key sebagai string
    protected $keyType = 'string';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_pengeluaran_uang_saku',
        'id_siswa',
        'nominal',
        'nama_pengeluaran',
        'tanggal_pengeluaran',
    ];

    // Relasi dengan tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pengeluaran_uang_saku AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pengeluaran_uang_saku + 1) : '1';
    }
}
