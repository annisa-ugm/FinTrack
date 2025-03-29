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
        Schema::create('pembayaran_ekstra', function (Blueprint $table) {
            // $table->id();
            $table->string('id_pembayaran_ekstra', 10)->primary();
            $table->string('id_siswa', 10)->nullable();
            $table->string('id_ekstra', 10)->nullable();
            $table->integer('nominal');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('set null');
            $table->foreign('id_ekstra')->references('id_ekstra')->on('ekstra')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_ekstra');
    }
};
