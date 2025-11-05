<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Ruangan extends Model
{
    // use HasFactory, SoftDeletes;

    protected $fillable = [
        // 'No',
        'Unit',
        'Ruangan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->No = Ruangan::max('No') + 1;
        });
    }
}
