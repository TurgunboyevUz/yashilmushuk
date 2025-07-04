<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $guarded = [];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
