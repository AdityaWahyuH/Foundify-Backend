<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_ditemukan', function (Blueprint $table) {
            $table->id('barang_ditemukan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_barang', 100);
            $table->text('deskripsi');
            $table->date('tanggal_ditemukan');
            $table->string('lokasi', 255);
            $table->string('lokasi_barang_ditemukan', 255)->nullable();
            $table->dateTime('jadwal_penjemputan')->nullable();
            $table->string('lokasi_penjemputan', 255)->nullable();
            $table->enum('status', ['tersedia', 'diklaim', 'selesai'])->default('tersedia');
            $table->string('foto', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_ditemukan');
    }
};
