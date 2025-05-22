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
        Schema::create('log_harga_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sampah_id')->constrained('sampah')->cascadeOnDelete();
            $table->decimal('harga_lama', 13, 2);
            $table->decimal('harga_baru', 13, 2);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_harga_sampah');
    }
};
