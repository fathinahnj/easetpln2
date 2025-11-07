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
            $table->unsignedInteger('No.');
            $table->unsignedInteger('No. Reg');
            $table->string('Nama Barang');
            $table->foreignId('Unit')->constrained('ruangans')->onDelete('cascade');
            $table->foreignId('Ruangan')->constrained('ruangans')->onDelete('cascade');
            $table->enum('Status', ['Baik', 'Rusak', 'Perlu Diperbaiki'])->default('Baik');
            $table->enum('progress_aksi', [
                'Tidak Ada',
                'Perlu Diganti',
                'Dibuang',
                'Belum Ditindak',
                'Sementara Diperbaiki'
            ])->default('Tidak Ada');
            $table->string('Deskripsi')->nullable();
            $table->enum('Urgensi', ['🔴', '🟡', '🟢'])->default('🟢');
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
