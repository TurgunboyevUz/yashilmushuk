<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $guarded = [];

    public function employees()
    {
        $this->hasMany(Employee::class);
    }

    public function students()
    {
        $this->hasMany(Student::class);
    }
}
