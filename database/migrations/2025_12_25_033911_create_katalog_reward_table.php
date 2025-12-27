<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('katalog_reward', function (Blueprint $table) {
            $table->id('katalog_id');
            $table->string('nama_reward', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('poin_required');
            $table->integer('stok')->default(0);
            $table->string('gambar', 255)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('katalog_reward');
    }
};
