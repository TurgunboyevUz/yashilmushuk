<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
