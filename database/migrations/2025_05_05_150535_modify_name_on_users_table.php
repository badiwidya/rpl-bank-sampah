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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_depan')->after('id');
            $table->string('nama_belakang')->after('nama_depan');
            $table->dropColumn('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->dropColumn('nama_depan');
            $table->dropColumn('nama_belakang');
        });
    }
};
