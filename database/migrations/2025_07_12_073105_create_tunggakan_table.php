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
        Schema::create('tunggakan', function (Blueprint $table) {
            $table->string('id_tunggakan', 10)->primary();
            $table->string('nisn');
            $table->string('nama_siswa');
            $table->string('jenis_tagihan'); // Umum, Boarding, Konsumsi, Uang Saku, Ekstra
            $table->string('nama_tagihan');  // Contoh: SPP, KBM, Ekstra Futsal
            $table->integer('nominal')->default(0);
            $table->string('periode'); // Contoh: Tahun ajaran 2024/2025
            $table->string('status')->default('Belum Lunas'); // Belum Lunas / Lunas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tunggakan');
    }
};
