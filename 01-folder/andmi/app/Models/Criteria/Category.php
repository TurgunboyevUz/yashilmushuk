<?php

namespace App\Models\Criteria;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }
}
