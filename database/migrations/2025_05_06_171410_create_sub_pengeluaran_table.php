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
        Schema::create('sub_pengeluaran', function (Blueprint $table) {
            // $table->id();
            $table->string('id_sub_pengeluaran')->primary();
            $table->string('id_pengeluaran');
            $table->string('id_kategori_pengeluaran');
            $table->string('id_user', 10);
            $table->string('nama_sub_pengeluaran');
            $table->integer('nominal');
            $table->integer('jumlah_item');
            // $table->integer('total');
            $table->text('file_nota')->nullable();
            $table->date('tanggal_pengeluaran');
            $table->timestamps();

            $table->foreign('id_pengeluaran')->references('id_pengeluaran')->on('pengeluaran')->onDelete('restrict');
            $table->foreign('id_kategori_pengeluaran')->references('id_kategori_pengeluaran')->on('kategori_pengeluaran')->onDelete('restrict');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_pengeluaran');
    }
};
