<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Barang extends Model
{
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    protected $fillable = [
        'no',
        'no_reg',      // Add this field
        'nama_barang',
        'unit',
        'ruangan',
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
}
