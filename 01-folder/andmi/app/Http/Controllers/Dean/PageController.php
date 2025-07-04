<?php
namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Models\Auth\Department;
use App\Models\Auth\Employee;
use App\Models\Auth\Student;
use App\Models\File\DistinguishedScholarship;
use App\Models\File\File;
use App\Models\Pivot\DepartmentEmployee;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard(Request $request)
    {
        $user       = $request->user();
        $title      = "Boshqaruv paneli";
        $department = $user->employee->department('dean');

        $male_students = Student::whereHas('user', function ($query) {
            $query->where('gender_id', 1);
        })
            ->where('faculty_id', $department->id)
            ->count();

        $female_students = Student::whereHas('user', function ($query) {
            $query->where('gender_id', 2);
        })
            ->where('faculty_id', $department->id)
            ->count();

        $file_male_students = DistinguishedScholarship::whereHas('user_id.student', function ($query) use ($department) {
            $query->where('faculty_id', $department->id)
                ->whereHas('user', function ($query) {
                    $query->where('gender_id', 1);
                });
        })->count();

        $file_female_students = DistinguishedScholarship::whereHas('user_id.student', function ($query) use ($department) {
            $query->where('faculty_id', $department->id)
                ->whereHas('user', function ($query) {
                    $query->where('gender_id', 2);
                });
        })->count();

        $counts = [
            'students' => [
                'male'   => $male_students,
                'female' => $female_students,
            ],

            'file'     => [
                'male'   => $file_male_students,
                'female' => $file_female_students,
            ],
        ];

        return view('dean.dashboard', compact('user', 'title', 'department', 'counts'));
    }

    public function attach_student(Request $request)
    {
        $user        = $request->user();
        $title       = "Talabani biriktirish";
        $department  = $user->employee->department('dean');
        $departments = $department->departments;

        $students = $department->students()
            ->where('employee_id', null)
            ->with(['user', 'direction'])
            ->get();

        $teachers = DepartmentEmployee::whereIn('department_id', $departments->pluck('id'))
            ->with(['employee.user', 'employee.specialty', 'department'])
            ->get();

        return view('dean.attach-student', compact('user', 'title', 'teachers', 'students'));
    }

    public function attached_students(Request $request)
    {
        $user       = $request->user();
        $title      = "Biriktirilgan talabalar ro'yxati";
        $department = $user->employee->department('dean');
        $students   = Student::with(['user', 'employee.user', 'employee.departments', 'direction', 'group',
            'faculty' => function ($query) use ($department) {
                $query->where('id', $department->id);
            }])->get();

        $students = $students->filter(function ($student) {
            return $student->employee != null;
        });

        return view('dean.attached-students', compact('user', 'title', 'students', 'department'));
    }

    public function distinguished_scholarship(Request $request)
    {
        $user  = $request->user();
        $title = "Nomdor stipendiyaga ariza topshirganlar";
        $files = File::where('fileable_type', DistinguishedScholarship::class)
            ->whereIn('type', ['passport', 'rating_book', 'faculty_statement', 'department_recommendation'])
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        $files = $files->groupBy('fileable_id');

        return view('dean.distinguished-scholarship', compact('user', 'title', 'files'));
    }

    public function edit_profile(Request $request)
    {
        $user = $request->user();
        $title = "Profilni tahrirlash";

        return view('dean.edit-profile', compact('user', 'title'));
    }
}
