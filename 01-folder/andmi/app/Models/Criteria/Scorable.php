<?php

namespace App\Models\Criteria;

use Illuminate\Database\Eloquent\Model;

class Scorable extends Model
{
    protected $guarded = [];

    public function scorable()
    {
        return $this->morphTo();
    }
}
