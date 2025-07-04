<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = ['name', 'key', 'video'];

    public function path()
    {
        return asset('storage/'.$this->video);
    }
}
