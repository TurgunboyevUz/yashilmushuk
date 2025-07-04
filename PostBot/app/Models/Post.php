<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function buttons()
    {
        return $this->hasMany(Button::class);
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
