<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Session;
use Illuminate\Support\Str;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Session::insert([
            [
                'id' => Str::uuid(),
                'id_user' => '1',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'payload' => json_encode(['session_data' => 'example']),
                'last_activity' => time(),
            ],
            [
                'id' => Str::uuid(),
                'id_user' => '1',
                'ip_address' => '192.168.1.2',
                'user_agent' => 'Mozilla/5.0',
                'payload' => json_encode(['session_data' => 'example']),
                'last_activity' => time(),
            ]
        ]);
    }
}
