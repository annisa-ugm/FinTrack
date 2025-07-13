<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tunggakan extends Model
{
    use HasFactory;

    protected $table = 'tunggakan';
    protected $primaryKey = 'id_tunggakan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tunggakan',
        'nisn',
        'nama_siswa',
        'jenis_tagihan',
        'nama_tagihan',
        'nominal',
        'periode',
        'status',
    ];

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_tunggakan AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_tunggakan + 1) : '1';
    }
}
