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
        Schema::create('history_laporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('no')->nullable();
            $table->unsignedInteger('no_reg')->nullable();

            // Langsung salin nilai string, bukan foreign key
            $table->string('nama_barang');
            $table->string('unit')->nullable();
            $table->string('ruangan')->nullable();

            $table->string('status');
            $table->string('progress_aksi')->nullable();
            $table->string('deskripsi')->nullable();

            $table->date('tanggal_laporan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_laporans');
    }
};
