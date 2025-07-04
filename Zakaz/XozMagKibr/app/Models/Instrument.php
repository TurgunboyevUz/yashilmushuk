<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $guarded = [];

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
