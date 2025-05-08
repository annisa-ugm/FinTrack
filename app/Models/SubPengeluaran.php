<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPengeluaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sub_pengeluaran';
    protected $primaryKey = 'id_sub_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_sub_pengeluaran',
        'id_pengeluaran',
        'id_kategori_pengeluaran',
        'id_user',
        'nama_sub_pengeluaran',
        'nominal',
        'jumlah_item',
        'file_nota',
        'tanggal_pengeluaran',

    ];

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'id_pengeluaran', 'id_pengeluaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kategoriPengeluaran()
    {
        return $this->belongsTo(KategoriPengeluaran::class, 'id_kategori_pengeluaran', 'id_kategori_pengeluaran');
    }

    // public function getFileNotaUrlAttribute()
    // {
    //     return $this->file_nota ? asset($this->file_nota) : null;
    // }

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_sub_pengeluaran AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_sub_pengeluaran + 1) : '1';
    }
}
