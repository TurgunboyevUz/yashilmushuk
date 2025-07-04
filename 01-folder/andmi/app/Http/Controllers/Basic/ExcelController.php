<?php
namespace App\Http\Controllers\Basic;

use App\Exports\AttachedStudentExport;
use App\Exports\DeanStudentExport;
use App\Exports\DSExport;
use App\Exports\GeneralFacultyExport;
use App\Exports\GeneralInstituteExport;
use App\Exports\StudentFacultyExport;
use App\Exports\StudentInstituteExport;
use App\Exports\TeacherDepartmentExport;
use App\Exports\TeacherFacultyExport;
use App\Exports\TeacherInstituteExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function attached_students(Request $request)
    {
        $class = new AttachedStudentExport($request);
        $file = now()->format('d_m_Y_His') . '_attached_students.xlsx';

        return Excel::download($class, $file);
    }

    public function attached_students_list(Request $request)
    {
        $class = new DeanStudentExport($request);
        $file = now()->format('d_m_Y_His') . '_attached_students_list.xlsx';

        return Excel::download($class, $file);
    }

    public function distinguished_scholarship(Request $request)
    {
        $class = new DSExport($request);
        $file = now()->format('d_m_Y_His') . '_distinguished_scholarship.xlsx';

        return Excel::download($class, $file);
    }

    public function department(Request $request)
    {
        $class = new TeacherDepartmentExport($request);
        $file = now()->format('d_m_Y_His') . '_department.xlsx';

        return Excel::download($class, $file);
    }

    public function faculty(Request $request)
    {
        $class = new TeacherFacultyExport($request);
        $file = now()->format('d_m_Y_His') . '_faculty.xlsx';

        return Excel::download($class, $file);
    }

    public function institute(Request $request)
    {
        $class = new TeacherInstituteExport($request);
        $file = now()->format('d_m_Y_His') . '_institute.xlsx';

        return Excel::download($class, $file);
    }

    public function general_faculty(Request $request)
    {
        $class = new GeneralFacultyExport($request);
        $file = now()->format('d_m_Y_His') . '_general_faculty.xlsx';

        return Excel::download($class, $file);
    }

    public function general_institute(Request $request)
    {
        $class = new GeneralInstituteExport($request);
        $file = now()->format('d_m_Y_His') . '_general_institute.xlsx';

        return Excel::download($class, $file);
    }

    public function student_faculty(Request $request)
    {
        $class = new StudentFacultyExport($request);
        $file = now()->format('d_m_Y_His') . '_student_faculty.xlsx';

        return Excel::download($class, $file);
    }

    public function student_institute(Request $request)
    {
        $class = new StudentInstituteExport($request);
        $file = now()->format('d_m_Y_His') . '_student_institute.xlsx';

        return Excel::download($class, $file);
    }
}
