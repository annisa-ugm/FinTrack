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
        Schema::create('ekstra_siswa', function (Blueprint $table) {
            // $table->id();
            $table->string('id_ekstra_siswa', 10)->primary();
            $table->string('id_siswa', 10);
            $table->string('id_ekstra', 10)->nullable();
            $table->integer('durasi');
            $table->integer('tagihan_ekstra');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_ekstra')->references('id_ekstra')->on('ekstra')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstra_siswa');
    }
};
