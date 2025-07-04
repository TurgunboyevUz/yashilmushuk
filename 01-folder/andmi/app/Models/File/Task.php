<?php

namespace App\Models\File;

use App\Models\Auth\Employee;
use App\Models\Auth\Student;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use Fileable;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
