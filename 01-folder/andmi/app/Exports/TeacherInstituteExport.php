<?php

namespace App\Exports;

use App\Enums\StructureType;
use App\Models\File\File;
use App\Models\Pivot\DepartmentEmployee;
use App\Traits\ExcelStyle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Spatie\Permission\Models\Role;

class TeacherInstituteExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    use ExcelStyle;

    protected $index = 1;
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $role     = Role::where('name', 'teacher')->first();
        $teachers = DepartmentEmployee::where('role_id', $role->id)->with(['employee.user.teacher_files', 'employee.students', 'employee.departments', 'employee.specialty'])->get();

        $teachers = $teachers->sortByDesc(function ($teacher) {
            return $teacher->employee->user->teacher_files->sum('teacher_score');
        });

        $teachers = $teachers->unique(function ($teacher) {
            return $teacher->employee_id . '-' . $teacher->role_id;
        });

        $map = $teachers->map(function ($teacher) use ($role) {
            $faculty    = $teacher->employee->departments->where('structure_code', StructureType::FACULTY->value)->where('pivot.role_id', $role->id)->first();
            $department = $teacher->employee->departments->where('structure_code', StructureType::DEPARTMENT->value)->where('pivot.role_id', $role->id)->first();

            return [
                'fio'            => $teacher->employee->user->short_fio(),
                'faculty'        => $faculty->name,
                'department'     => $department->name,
                'staff_position' => $department->pivot->staff_position,
                'student_count'  => $teacher->employee->students->count(),
                'total_score'    => $teacher->employee->user->teacher_files->sum('teacher_score'),
            ];
        });

        return $map;
    }

    public function headings(): array
    {
        return [
            '#',
            'Xodim ism, familiyasi',
            'Fakultet',
            'Kafedra',
            'Lavozimi',
            'Biriktirilgan talabalar soni',
            'Jami ball',
        ];
    }

    public function map($user): array
    {
        return [
            $this->index++,
            $user['fio'],
            $user['faculty'],
            $user['department'],
            $user['staff_position'],
            $user['student_count'],
            (string) $user['total_score']
        ];
    }
}
