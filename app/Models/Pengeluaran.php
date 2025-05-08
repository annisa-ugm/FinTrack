<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengeluaran',
        'id_jenis_pengeluaran',
        'id_user',
        'nama_pengeluaran',
        'total_pengeluaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function jenisPengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis_pengeluaran', 'id_jenis_pengeluaran');
    }

    public function subPengeluaran()
    {
        return $this->hasMany(SubPengeluaran::class, 'id_pengeluaran', 'id_pengeluaran');
    }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_pengeluaran AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_pengeluaran + 1) : '1';
    }
}
