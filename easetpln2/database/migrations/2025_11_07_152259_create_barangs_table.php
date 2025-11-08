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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('no');
            $table->unsignedInteger('no_reg');
            $table->string('nama_barang');
            $table->foreignId('unit')->constrained('ruangans')->onDelete('cascade');
            $table->foreignId('ruangan')->constrained('ruangans')->onDelete('cascade');
            $table->enum('status', ['Baik', 'Rusak', 'Perlu Diperbaiki'])->default('Baik');
            $table->enum('progress_aksi', [
                'Tidak Ada',
                'Perlu Diganti',
                'Dibuang',
                'Belum Ditindak',
                'Sementara Diperbaiki'
            ])->default('Tidak Ada');
            $table->string('deskripsi')->nullable();
            $table->enum('urgensi', ['Tinggi', 'Sedang', 'Rendah'])->default('Rendah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
