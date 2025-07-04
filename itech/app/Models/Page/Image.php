<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public function carousel(){
        return $this->hasOne(Carousel::class);
    }
}
