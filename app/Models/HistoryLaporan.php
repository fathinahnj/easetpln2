<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryLaporan extends Model
{
    use HasFactory;

    protected $table = 'history_laporans'; // nama tabel di database

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'no_reg', 'no_reg');
    }


    protected $fillable = [
        'no',
        'no_reg',
        'nama_barang',
        'unit',
        'ruangan',
        'status',
        'progress_aksi',
        'deskripsi',
        'tanggal_laporan',
    ];

    // Jika tanggal_laporan adalah kolom tanggal, Laravel akan otomatis meng-cast-nya ke Carbon
    protected $casts = [
        'tanggal_laporan' => 'datetime',
    ];
}
