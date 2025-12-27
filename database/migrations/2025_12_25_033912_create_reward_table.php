<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reward', function (Blueprint $table) {
            $table->id('reward_id');
            $table->unsignedBigInteger('barang_hilang_id')->nullable();
            $table->string('judul', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('nominal', 10, 2)->default(0);
            $table->string('gambar', 255)->nullable();
            $table->enum('status', ['active', 'claimed', 'expired'])->default('active');
            $table->timestamps();

            $table->foreign('barang_hilang_id')->references('barang_hilang_id')->on('barang_hilang')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward');
    }
};
