<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PasswordResetToken;
use Illuminate\Support\Str;

class PasswordResetTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PasswordResetToken::insert([
            [
                'email' => 'bendahara@example.com',
                'token' => Str::random(60),
                'created_at' => now(),
            ],
            [
                'email' => 'kepalasekolah@example.com',
                'token' => Str::random(60),
                'created_at' => now(),
            ]
        ]);
    }
}
