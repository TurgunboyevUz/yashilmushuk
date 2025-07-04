<?php
namespace App\Exports;

use App\Models\Auth\Student;
use App\Traits\ExcelStyle;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class StudentFacultyExport implements FromCollection, WithMapping, WithHeadings, WithStyles
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
        $department = $user->student->faculty;

        $students = Student::where('faculty_id', $department->id)->with(['user.student_files', 'employee', 'faculty', 'direction', 'group'])->get();

        $students = $students->sortByDesc(function ($student) {
            return $student->user->student_files->sum('student_score');
        });

        $map = $students->map(function ($student) {
            return [
                'fio'         => $student->user->short_fio(),
                'level'       => $student->level,
                'direction'   => $student->direction->name,
                'total_score' => $student->user->student_files->sum('student_score'),
            ];
        });

        return $map;
    }

    public function headings(): array
    {
        return [
            '#',
            'Talaba ism, familiyasi',
            'Kursi',
            'Yo\'nalishi',
            'Jami ball',
        ];
    }

    public function map($student): array
    {
        return [
            $this->index++,
            $student['fio'],
            $student['level'],
            $student['direction'],
            (string) $student['total_score'],
        ];
    }
}
