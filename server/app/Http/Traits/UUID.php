<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait UUID
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::random(6);
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

   /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
