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
        Schema::create('boarding_siswa', function (Blueprint $table) {
            $table->string('id_boarding_siswa', 10)->primary();
            $table->string('id_siswa', 10);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('tagihan_boarding');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_siswa');
    }
};
