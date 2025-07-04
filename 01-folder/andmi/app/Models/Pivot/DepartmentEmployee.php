<?php

namespace App\Models\Pivot;

use App\Models\Auth\Department;
use App\Models\Auth\Employee;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DepartmentEmployee extends Pivot
{
    protected $table = 'department_employee';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}