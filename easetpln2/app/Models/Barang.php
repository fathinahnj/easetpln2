<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastRecord = static::latest('no')->first();
            $model->no = $lastRecord ? $lastRecord->no + 1 : 1;
        });
    }
}
