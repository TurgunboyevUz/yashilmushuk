<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function employees()
    {
        return $this->belongsToMany(Employee::class)
            ->withPivot(['staff_position', 'employee_type'])
            ->withTimestamps();
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'faculty_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'parent_id', 'id');
    }
}
