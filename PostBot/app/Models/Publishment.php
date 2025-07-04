<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publishment extends Model
{
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
}
