<?php

namespace App\Models\Magazine;

use Illuminate\Database\Eloquent\Model;

class MagazineCategory extends Model
{
    protected $guarded = [];

    public function magazines()
    {
        return $this->hasMany(Magazine::class);
    }
}
