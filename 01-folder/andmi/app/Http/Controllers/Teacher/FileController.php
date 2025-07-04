<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\StructureType;
use App\Facade\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreProfileRequest;
use App\Http\Requests\Teacher\StoreTaskRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class FileController extends Controller
{
    public function task(StoreTaskRequest $request)
    {
        $user = $request->user();

        File::user($request)->task($request);

        $this->toast('Topshiriq muvaffaqiyatli yaratildi!');

        return redirect()->route($request->route()->getName());
    }

    public function destroy_task(Request $request)
    {
        File::destroy_task($request->input('id'));

        $this->toast('Topshiriq muvaffaqiyatli o\'chirildi!', 'info');

        return redirect()->back();
    }

    public function edit_profile(StoreProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if (! $user->employee->department('teacher', StructureType::FACULTY->value)) {
            $role_id = Role::where('name', 'teacher')->first()->id;
            $user->employee->departments()->attach($data['faculty_id'], [
                'role_id' => $role_id,
            ]);
        }

        $user->update([
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $this->toast('Profil muvaffaqiyatli yangilandi!');

        return redirect()->route($request->route()->getName());
    }

    public function toast($message, $type = 'success')
    {
        toast($message, $type, 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }
}
