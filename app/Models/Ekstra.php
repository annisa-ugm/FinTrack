<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstra extends Model
{
    use HasFactory;

    protected $table = 'ekstra';
    protected $primaryKey = 'id_ekstra';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ekstra',
        'nama_ekstra',
        'biaya_ekstra',
    ];

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_ekstra AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_ekstra + 1) : '1';
    }
}
