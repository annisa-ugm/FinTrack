<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'id_siswa',
        'nama_siswa',
        'nisn',
        'level',
        'kategori',
        'akademik',
        'nama_wali',
        'no_hp_wali',
        'file_kontrak',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_siswa', 'id_siswa');
    }

    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_siswa', 'id_siswa');
    }

    public function boarding()
    {
        return $this->hasOne(BoardingSiswa::class, 'id_siswa', 'id_siswa');
    }

    public function konsumsi()
    {
        return $this->hasOne(KonsumsiSiswa::class, 'id_siswa', 'id_siswa');
    }

    public function uangSaku()
    {
        return $this->hasOne(UangSaku::class, 'id_siswa', 'id_siswa');
    }

    public function kontrak()
    {
        return $this->hasOne(KontrakSiswa::class, 'id_siswa', 'id_siswa');
    }

    // public function boardingSiswa()
    // {
    //     return $this->hasMany(BoardingSiswa::class, 'id_siswa', 'id_siswa');
    // }

    // public function konsumsiSiswa()
    // {
    //     return $this->hasMany(KonsumsiSiswa::class, 'id_siswa', 'id_siswa');
    // }


    public static function generateId()
    {
        $last = self::orderByRaw('CAST(id_siswa AS UNSIGNED) DESC')->first();
        return $last ? (string)((int)$last->id_siswa + 1) : '1';
    }


}
