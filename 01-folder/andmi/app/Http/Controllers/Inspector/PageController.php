<?php
namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Models\Auth\Student;
use App\Models\Criteria\Category;
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

class PageController extends Controller
{
    public function dashboard(Request $request)
    {
        $user       = $request->user();
        $title      = "Boshqaruv paneli";
        $department = $user->employee->department('inspeksiya');

        $top3_stu = (new Rating($user))->getRating(Rating::ALL, Rating::STUDENT)->take(3);
        $top3_ins = (new Rating($user))->getRating(Rating::ALL, Rating::TEACHER)->take(3);

        $data = compact('top3_stu', 'top3_ins');

        return view('inspeksiya.dashboard', compact('user', 'title', 'department', 'data'));
    }

    public function article(Request $request)
    {
        $user  = $request->user();
        $title = "Maqolalar";
        $files = File::where('fileable_type', Article::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.article', compact('user', 'title', 'files'));
    }

    public function scholarship(Request $request)
    {
        $user  = $request->user();
        $title = "Stipendiyat";
        $files = File::where('fileable_type', Scholarship::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.scholarship', compact('user', 'title', 'files'));
    }

    public function invention(Request $request)
    {
        $user  = $request->user();
        $title = "Ixtiro/DGU/Foydali model";
        $files = File::where('fileable_type', Invention::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.invention', compact('user', 'title', 'files'));
    }

    public function startup(Request $request)
    {
        $user  = $request->user();
        $title = "Startup/Tanlov";
        $files = File::where('fileable_type', Startup::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.startup', compact('user', 'title', 'files'));
    }

    public function grand_economy(Request $request)
    {
        $user  = $request->user();
        $title = "Grant/Xo'jalik shartnomalar";
        $files = File::where('fileable_type', GrandEconomy::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.grand-economy', compact('user', 'title', 'files'));
    }

    public function olympics(Request $request)
    {
        $user  = $request->user();
        $title = "Olimpiadalar";
        $files = File::where('fileable_type', Olympic::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.olympics', compact('user', 'title', 'files'));
    }

    public function lang_certificate(Request $request)
    {
        $user  = $request->user();
        $title = "Til sertifikatlari";
        $files = File::where('fileable_type', LangCertificate::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.lang-certificate', compact('user', 'title', 'files'));
    }

    public function achievement(Request $request)
    {
        $user  = $request->user();
        $title = "O'quv yili davomida erishgan boshqa yutuqlari";
        $files = File::where('fileable_type', Achievement::class)
            ->where('status', '!=', 'pending')
            ->orderByRaw("FIELD(status, 'reviewed', 'approved', 'rejected')")
            ->get();

        return view('inspeksiya.achievement', compact('user', 'title', 'files'));
    }

    public function student_list(Request $request)
    {
        $user     = $request->user();
        $title    = "Talabalar ro'yxati";
        $students = Student::all();

        return view('inspeksiya.student-list', compact('user', 'title', 'students'));
    }

    public function evaluation_criteria(Request $request)
    {
        $user       = $request->user();
        $title      = "Baholash me'zonini o'zgartirish";
        $categories = Category::all();

        return view('inspeksiya.evaluation-criteria', compact('user', 'title', 'categories'));
    }

    public function edit_profile(Request $request)
    {
        $user  = $request->user();
        $title = "Profilni tahrirlash";

        return view('inspeksiya.edit-profile', compact('user', 'title'));
    }
}
