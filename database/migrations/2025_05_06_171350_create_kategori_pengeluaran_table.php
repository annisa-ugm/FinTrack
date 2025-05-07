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
        Schema::create('kategori_pengeluaran', function (Blueprint $table) {
            // $table->id();
            $table->string('id_kategori_pengeluaran')->primary();
            $table->string('id_jenis_pengeluaran');
            $table->string('nama_kategori_pengeluaran');
            $table->timestamps();

            $table->foreign('id_jenis_pengeluaran')->references('id_jenis_pengeluaran')->on('jenis_pengeluaran')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_pengeluaran');
    }
};
