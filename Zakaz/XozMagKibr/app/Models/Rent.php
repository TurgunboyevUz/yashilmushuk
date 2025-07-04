<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $guarded = [];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
