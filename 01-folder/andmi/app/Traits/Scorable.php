<?php

namespace App\Traits;

use App\Models\Criteria\Scorable as ScorableModel;
use App\Models\Criteria\Score;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Scorable
{
    public function scorable(): MorphOne
    {
        return $this->morphOne(ScorableModel::class, 'scorable');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
