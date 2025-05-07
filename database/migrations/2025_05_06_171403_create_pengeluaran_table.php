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
        Schema::create('pengeluaran', function (Blueprint $table) {
            // $table->id();
            $table->string('id_pengeluaran')->primary();
            $table->string('id_jenis_pengeluaran');
            $table->string('id_user', 10);
            $table->string('nama_pengeluaran');
            $table->integer('total_pengeluaran');
            $table->timestamps();

            $table->foreign('id_jenis_pengeluaran')->references('id_jenis_pengeluaran')->on('jenis_pengeluaran')->onDelete('restrict');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
