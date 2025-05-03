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
        Schema::create('transaksi_penukaran_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_penukaran_id')->constrained('transaksi_penukaran')->cascadeOnDelete();
            $table->foreignId('sampah_id')->constrained('sampah')->cascadeOnDelete();
            $table->decimal('berat', 8, 3);
            $table->decimal('harga_subtotal', 13, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penukaran_sampah');
    }
};
