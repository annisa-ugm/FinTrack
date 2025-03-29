<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens'; // Nama tabel eksplisit

    protected $primaryKey = 'email'; // Primary key adalah email

    public $incrementing = false; // Karena primary key bukan integer

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    public $timestamps = false; // Tidak menggunakan timestamps default (created_at & updated_at)
}
