<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Barang extends Model
{
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    protected $fillable = [
        'no',
        'no_reg',      // Add this field
        'nama_barang',
        'ruangan_id',
        'status',
        'progress_aksi',
        'deskripsi',
        'urgensi'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastRecord = static::latest('no')->first();
            $model->no = $lastRecord ? $lastRecord->no + 1 : 1;
        });
    }

    protected static function booted()
    {
        static::created(function ($barang) {
            \App\Models\HistoryLaporan::create([
                'no_reg' => $barang->no_reg,
                'nama_barang' => $barang->nama_barang,
                'unit' => $barang->unit,
                'ruangan' => $barang->ruangan,
                'status' => $barang->status,
                'progress_aksi' => $barang->progress_aksi,
                'deskripsi' => $barang->deskripsi,
                'tanggal_laporan' => now(),
            ]);
        });
    }
}
