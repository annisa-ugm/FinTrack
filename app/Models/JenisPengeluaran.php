<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jenis_pengeluaran',
        'nama_jenis_pengeluaran',
    ];

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_jenis_pengeluaran AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_jenis_pengeluaran + 1) : '1';
    }
}
