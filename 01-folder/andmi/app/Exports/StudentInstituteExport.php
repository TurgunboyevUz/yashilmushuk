<?php
namespace App\Exports;

use App\Models\Auth\Student;
use App\Traits\ExcelStyle;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class StudentInstituteExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
        $students = Student::with(['user.student_files', 'employee', 'faculty', 'direction', 'group'])->get();

        $students = $students->sortByDesc(function ($student) {
            return $student->user->student_files->sum('student_score');
        });

        $map = $students->map(function ($student) {
            return [
                'fio'         => $student->user->short_fio(),
                'level'       => $student->level,
                'faculty'     => $student->faculty->name,
                'direction'   => $student->direction->name,
                'total_score' => $student->user->student_files->sum('student_score'),
            ];
        });

        return $map;
    }

    public function map($user): array
    {
        return [
            $this->index++,
            $user['fio'],
            $user['level'],
            $user['faculty'],
            $user['direction'],
            (string) $user['total_score'],
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Talaba ism, familiyasi',
            'Kursi',
            'Fakultet',
            'Yo\'nalishi',
            'Jami ball',
        ];
    }
}
