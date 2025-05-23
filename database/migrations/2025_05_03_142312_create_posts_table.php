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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // Kalo user terhapus buat post masih ada, tapi author jadiin null aja
            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('judul');
            $table->string('cover_url')->nullable();
            $table->string('slug')->unique();
            $table->text('konten');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
