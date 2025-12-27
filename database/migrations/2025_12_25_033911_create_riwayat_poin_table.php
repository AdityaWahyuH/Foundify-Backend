<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_poin', function (Blueprint $table) {
            $table->id('riwayat_id');
            $table->unsignedBigInteger('poin_id');
            $table->integer('jumlah_poin');
            $table->string('keterangan', 255);
            $table->timestamp('tanggal_transaksi')->useCurrent();

            $table->foreign('poin_id')->references('poin_id')->on('poin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_poin');
    }
};
