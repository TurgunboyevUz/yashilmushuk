<?php

namespace App\Models\Auth;

use App\Enums\StructureType;
use App\Models\File\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
    protected $guarded = [];

    public function departments()
    {
        return $this->belongsToMany(Department::class)
            ->withPivot(['role_id', 'department_id', 'staff_position', 'employee_type'])
            ->withTimestamps();
    }

    public function department($role_code, $structure_code = StructureType::FACULTY->value)
    {
        $role = Role::where('name', $role_code)->first();

        return $this->departments()
            ->wherePivot('role_id', $role->id)
            ->where('structure_code', $structure_code)
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
