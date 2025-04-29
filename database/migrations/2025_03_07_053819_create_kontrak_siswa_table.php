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
        Schema::create('kontrak_siswa', function (Blueprint $table) {
            // $table->id();
            $table->string('id_kontrak_siswa', 10)->primary();
            $table->string('id_siswa', 10);
            $table->integer('uang_kbm');
            $table->integer('uang_spp');
            $table->integer('uang_pemeliharaan');
            // $table->integer('uang_boarding')->nullable();
            // $table->integer('uang_konsumsi')->nullable();
            $table->integer('uang_sumbangan');
            $table->text('catatan')->nullable();
            $table->text('file_kontrak');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_siswa');
    }
};
