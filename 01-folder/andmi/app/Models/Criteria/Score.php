<?php

namespace App\Models\Criteria;

use App\Traits\Scorable;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use Scorable;

    protected $guarded = [];
}
