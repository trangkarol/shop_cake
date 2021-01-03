<?php

namespace App\Traits\Models;

use Illuminate\Support\Str;

trait GenerationUiid 
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
