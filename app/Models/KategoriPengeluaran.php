<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kategori_pengeluaran',
        'id_jenis_pengeluaran',
        'nama_kategori_pengeluaran',
    ];

    public function jenisPengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis_pengeluaran', 'id_jenis_pengeluaran');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_kategori_pengeluaran AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_kategori_pengeluaran + 1) : '1';
    }
}
