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

class TeacherDepartmentExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $user       = $this->request->user();
        $department = $user->employee->department('teacher', StructureType::DEPARTMENT->value);

        $role     = Role::where('name', 'teacher')->first();
        $teachers = DepartmentEmployee::where('department_id', $department->id)->with(['employee.user.teacher_files', 'employee.students', 'employee.departments', 'employee.specialty'])->get();

        $teachers = $teachers->sortByDesc(function ($teacher) {
            return $teacher->employee->user->teacher_files->sum('teacher_score');
        });

        $map = $teachers->map(function ($teacher) use ($role) {
            return [
                'fio'            => $teacher->employee->user->short_fio(),

                'department'     => $teacher->employee->departments
                    ->where('structure_code', StructureType::DEPARTMENT->value)
                    ->where('pivot.role_id', $role->id)
                    ->first()->name,

                'staff_position' => $teacher->employee->departments
                    ->where('structure_code', StructureType::DEPARTMENT->value)
                    ->where('pivot.role_id', $role->id)
                    ->first()->pivot->staff_position,

                'total_score'    => $teacher->employee->user->teacher_files->sum('teacher_score'),
                'student_count'  => $teacher->employee->students->count(),
            ];
        });

        return $map;
    }

    public function headings(): array
    {
        return [
            '#',
            'Xodim ism, familiyasi',
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
            $user['staff_position'],
            $user['student_count'],
            (string) $user['total_score'],
        ];
    }
}
