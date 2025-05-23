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
        Schema::create('hasil_tagihan', function (Blueprint $table) {
            $table->string('id_hasil_tagihan', 10)->primary();
            $table->string('id_siswa', 10);
            $table->string('id_user', 10);
            $table->string('nama_siswa', 255);
            $table->string('level', 10);
            $table->string('akademik', 20);
            $table->text('file_tagihan');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('restrict');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_tagihan');
    }
};
