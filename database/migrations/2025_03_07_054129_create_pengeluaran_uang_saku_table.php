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
        Schema::create('pengeluaran_uang_saku', function (Blueprint $table) {
            // $table->id();
            $table->string('id_pengeluaran_uang_saku', 10)->primary();
            $table->string('id_siswa', 10)->nullable();
            $table->string('id_user', 10);
            $table->integer('nominal');
            $table->date('tanggal_pengeluaran');
            $table->text('catatan');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('set null');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_uang_saku');
    }
};
