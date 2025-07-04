<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $guarded = [];

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
}
