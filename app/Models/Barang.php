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
    }
}
