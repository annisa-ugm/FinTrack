<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            // $table->id();
            $table->string('id_siswa', 10)->primary();
            $table->string('nama_siswa', 255);
            $table->string('nisn', 255);
            $table->string('level', 20)->nullable();
            $table->string('kategori', 20)->nullable();
            $table->string('akademik', 20);
            $table->string('nama_wali', 255);
            $table->string('no_hp_wali', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
