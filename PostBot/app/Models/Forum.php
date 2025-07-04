<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publishment()
    {
        return $this->hasOne(Publishment::class);
    }

    public function publishments()
    {
        return $this->hasMany(Publishment::class);
    }
}