<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $guarded = [];

    public function image(){
        return $this->belongsTo(Image::class);
    }
}
