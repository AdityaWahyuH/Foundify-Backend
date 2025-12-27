<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_hilang', function (Blueprint $table) {
            $table->id('barang_hilang_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_barang', 100);
            $table->text('deskripsi');
            $table->date('tanggal_hilang');
            $table->string('lokasi', 255);
            $table->enum('status', ['hilang', 'ditemukan', 'selesai'])->default('hilang');
            $table->string('foto', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_hilang');
    }
};
