<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengeluaran',
        'id_user',
        'tanggal_pengeluaran',
        'nama_pengeluaran',
        'nominal',
        'kelompok_pengeluaran',
        'catatan',
    ];

    /**
     * Relasi ke tabel users (Many to One).
     * Satu pengeluaran hanya dilakukan oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pengeluaran AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pengeluaran + 1) : '1';
    }
}
