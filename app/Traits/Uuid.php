<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * getIncrementing
     * dinonaktifkan karena menggunakan uuid
     * @return void
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * getKeyType
     * Get the auto-increment key type
     * @return void
     */
    public function getKeyType()
    {
        return 'string';
    }
}
