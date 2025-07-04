<?php

namespace App\Exports;

use App\Models\Auth\Student;
use App\Traits\ExcelStyle;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class DeanStudentExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $user = $this->request->user();
        $department = $user->employee->department('dean');
        $students = Student::with(['user', 'employee.user', 'employee.departments', 'direction', 'group',
            'faculty' => function ($query) use ($department) {
                $query->where('id', $department->id);
            }])->get();

        $students = $students->filter(function ($student) {
            return $student->employee != null;
        });

        return $students;
    }

    public function headings(): array
    {
        return [
            '#',
            'Talaba ism, familiyasi',
            'Yo\'nalish',
            'Guruhi',
            'Kursi',
            'Biriktirilgan o\'qituvchi',
        ];
    }

    public function map($student): array
    {
        return [
            $this->index++,
            $student->user->short_fio(),
            $student->direction->name,
            $student->group->name,
            $student->level,
            $student->employee->user->short_fio(),
        ];
    }
}
