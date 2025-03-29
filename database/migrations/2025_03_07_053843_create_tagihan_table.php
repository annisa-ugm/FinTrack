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
        Schema::create('tagihan', function (Blueprint $table) {
            // $table->id();
            $table->string('id_tagihan', 10)->primary();
            $table->string('id_siswa', 10);
            $table->integer('tagihan_uang_kbm');
            $table->integer('tagihan_uang_spp');
            $table->integer('tagihan_uang_pemeliharaan');
            $table->integer('tagihan_uang_konsumsi');
            $table->integer('tagihan_uang_boarding');
            $table->integer('tagihan_uang_sumbangan');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
