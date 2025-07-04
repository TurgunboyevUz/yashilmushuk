<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    protected $guarded = [];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
