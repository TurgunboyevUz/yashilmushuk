<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    public function serials()
    {
        return $this->hasMany(Serial::class);
    }
}
