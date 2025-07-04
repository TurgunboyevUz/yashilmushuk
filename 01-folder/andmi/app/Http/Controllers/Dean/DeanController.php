<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dean\StoreProfileRequest;
use App\Models\Auth\Department;
use App\Models\Auth\Student;
use App\Models\File\File;
use Illuminate\Http\Request;

class DeanController extends Controller
{
    public function student_list(Request $request, $faculty)
    {
        $faculty = Department::where('id', $faculty)->first();
        $data = $faculty->students()->with(['user', 'faculty', 'direction', 'group'])
            ->where('employee_id', null)->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function department_list(Request $request, $faculty)
    {
        $faculty = Department::where('id', $faculty)->first();
        $data = $faculty->departments;

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function employee_list(Request $request, $department)
    {
        $department = Department::where('id', $department)->first();
        $data = $department->employees()->with('user')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function attach_student(Request $request)
    {
        $data = $request->data;

        foreach ($data as $item) {
            $student = Student::find($item['student_id']);
            $student->employee_id = $item['employee_id'];
            $student->save();
        }

        return response()->json([
            'success' => true,
            'data' => [],
        ]);
    }

    public function detach_student(Request $request)
    {
        $student = Student::find($request->id);
        $employee = $student->employee;

        $student->update(['employee_id' => null]);
        
        File::where('teacher_id', $employee->user_id)->where('uploaded_by', $student->user_id)->update([
            'teacher_score' => 0
        ]);

        $this->toast('Talaba muvaffaqiyatli o\'chirildi!');

        return redirect()->back();
    }

    public function edit_profile(StoreProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $this->toast('Profil muvaffaqiyatli yangilandi!');

        return redirect()->route($request->route()->getName());
    }

    public function toast($message)
    {
        toast($message, 'success', 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }
}
