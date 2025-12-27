<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klaim', function (Blueprint $table) {
            $table->id('klaim_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_ditemukan_id');
            $table->text('bukti_kepemilikan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('tanggal_klaim')->useCurrent();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
            $table->foreign('barang_ditemukan_id')->references('barang_ditemukan_id')->on('barang_ditemukan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klaim');
    }
};
