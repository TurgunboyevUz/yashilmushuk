<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\StructureType;
use App\Http\Controllers\Controller;
use App\Models\Auth\Department;
use App\Models\Chat\Chat;
use App\Models\File\Achievement;
use App\Models\File\Article;
use App\Models\File\File;
use App\Models\File\GrandEconomy;
use App\Models\File\Invention;
use App\Models\File\LangCertificate;
use App\Models\File\Olympic;
use App\Models\File\Scholarship;
use App\Models\File\Startup;
use App\Service\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $title = "Boshqaruv paneli";

        $top3_att = (new Rating($user))->getRating(Rating::ATTACHED, Rating::STUDENT)->take(3);
        $top3_dep = (new Rating($user))->getRating(Rating::DEPARTMENT, Rating::TEACHER)->take(3);
        $top3_fac = (new Rating($user))->getRating(Rating::FACULTY, Rating::TEACHER)->take(3);
        $top3_ins = (new Rating($user))->getRating(Rating::ALL, Rating::TEACHER)->take(3);

        $faculty = $user->employee->department('teacher', StructureType::FACULTY->value);
        $department = $user->employee->department('teacher', StructureType::DEPARTMENT->value);

        $data = compact('top3_att', 'top3_dep', 'top3_fac', 'top3_ins');

        return view('teacher.dashboard', compact('user', 'title', 'faculty', 'department', 'data'));
    }

    public function article(Request $request)
    {
        $user = $request->user();
        $title = "Maqolalar";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', Article::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('article')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.article', compact('user', 'title', 'files'));
    }

    public function scholarship(Request $request)
    {
        $user = $request->user();
        $title = "Stipendiyat";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', Scholarship::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('scholarship')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.scholarship', compact('user', 'title', 'files'));
    }

    public function invention(Request $request)
    {
        $user = $request->user();
        $title = "Ixtiro/DGU/Foydali model";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', Invention::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('invention')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.invention', compact('user', 'title', 'files'));
    }

    public function startup(Request $request)
    {
        $user = $request->user();
        $title = "Startup/Tanlov";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', Startup::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('startup')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.startup', compact('user', 'title', 'files'));
    }

    public function grand_economy(Request $request)
    {
        $user = $request->user();
        $title = "Grant/Xo'jalik shartnomalar";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', GrandEconomy::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('grand_economy')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.grand-economy', compact('user', 'title', 'files'));
    }

    public function olympics(Request $request)
    {
        $user = $request->user();
        $title = "Olimpiadalar";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', Olympic::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('olympic')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.olympics', compact('user', 'title', 'files'));
    }

    public function lang_certificate(Request $request)
    {
        $user = $request->user();
        $title = "Til sertifikatlari";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', LangCertificate::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('lang_certificate')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.lang-certificate', compact('user', 'title', 'files'));
    }

    public function achievement(Request $request)
    {
        $user = $request->user();
        $title = "O'quv yili davomida erishgan boshqa yutuqlari";

        $employee_id = $user->employee->id;
        $files = File::where('fileable_type', Achievement::class)
            ->whereHas('user.student', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->with('achievement')
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('teacher.achievement', compact('user', 'title', 'files'));
    }

    public function chat(Request $request)
    {
        $user = $request->user();
        $title = "Talabalar bilan chat";

        $students = $user->employee->students()->with('user')->get();

        $chats = $students->map(function ($student) use ($user) {
            $first_user_id = $user->id;
            $second_user_id = $student->user->id;

            $chat = Chat::where(function ($query) use ($first_user_id, $second_user_id) {
                $query->where('user_one_id', $first_user_id)
                    ->where('user_two_id', $second_user_id);
            })->orWhere(function ($query) use ($first_user_id, $second_user_id) {
                $query->where('user_one_id', $second_user_id)
                    ->where('user_two_id', $first_user_id);
            })->first();

            if (!$chat) {
                $chat = Chat::create([
                    'user_one_id' => $first_user_id,
                    'user_two_id' => $second_user_id,
                ]);
            }

            return $student->chat = $chat;
        });

        $current_chat = $request->query('chat');

        return view('teacher.chat', compact('user', 'title', 'students', 'current_chat'));
    }

    public function student_list(Request $request)
    {
        $user = $request->user();
        $title = "Talabalar ro'yxati";

        $students = $user->employee->students()->get();

        return view('teacher.student-list', compact('user', 'title', 'students'));
    }

    public function task(Request $request)
    {
        $user = $request->user();
        $title = "Topshiriq yaratish";

        $students = $user->employee->students()->get();
        $files = $user->employee->tasks;

        return view('teacher.tasks', compact('user', 'title', 'students', 'files'));
    }

    public function edit_profile(Request $request)
    {
        $user = $request->user();
        $title = "Profilni tahrirlash";

        $current_faculty = $user->employee->department('teacher', StructureType::FACULTY->value);
        $faculties = Department::where('structure_code', StructureType::FACULTY->value)->get();

        return view('teacher.edit-profile', compact('user', 'title', 'current_faculty', 'faculties'));
    }
}
