<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tukar_poin', function (Blueprint $table) {
            $table->id('tukar_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('katalog_id');
            $table->integer('jumlah_poin');
            $table->timestamp('tanggal_tukar')->useCurrent();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
            $table->foreign('katalog_id')->references('katalog_id')->on('katalog_reward')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tukar_poin');
    }
};
