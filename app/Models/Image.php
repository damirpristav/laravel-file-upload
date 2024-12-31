<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'url',
        'path',
        'type',
        'name',
        'size',
    ];

    // delete file when image is deleted in database
    protected static function booted()
    {
        static::deleting(function ($model) {
            if ($model->path !== null) {
                Storage::disk('local')->delete($model->path);
            }
        });
    }
}
