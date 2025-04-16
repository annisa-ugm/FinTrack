<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstra extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'ekstra';

    // Menonaktifkan auto-increment karena id_ekstra adalah string
    public $incrementing = false;

    // Menentukan tipe primary key sebagai string
    protected $keyType = 'string';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_ekstra',
        'nama_ekstra',
        'harga_ekstra',
    ];

    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_ekstra AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_ekstra + 1) : '1';
    }
}
