<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Service\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function attached_students(Request $request)
    {
        $user  = $request->user();
        $title = "Biriktirilgan talabalar reytingi";

        $students = (new Rating($user))->getRating(Rating::ATTACHED, Rating::STUDENT)->take(Rating::ALL);

        return view('teacher.rating.attached-students', compact('user', 'title', 'students'));
    }

    public function department(Request $request)
    {
        $user  = $request->user();
        $title = "Kafedra bo'yicha reytingi";

        $employees = (new Rating($user))->getRating(Rating::DEPARTMENT, Rating::TEACHER)->take(Rating::ALL);

        return view('teacher.rating.department', compact('user', 'title', 'employees'));
    }

    public function faculty(Request $request)
    {
        $user  = $request->user();
        $title = "Fakultet reytingi";

        $employees = (new Rating($user))->getRating(Rating::FACULTY, Rating::TEACHER)->take(Rating::ALL);

        return view('teacher.rating.faculty', compact('user', 'title', 'employees'));
    }

    public function institute(Request $request)
    {
        $user  = $request->user();
        $title = "Institut reytingi";

        $employees = (new Rating($user))->getRating(Rating::ALL, Rating::TEACHER)->take(Rating::ALL);

        return view('teacher.rating.institute', compact('user', 'title', 'employees'));
    }

    public function general_institute(Request $request)
    {
        $user  = $request->user();
        $title = "Talabalarning institut bo'yicha umumiy reytingi";

        $students = (new Rating($user))->getRating(Rating::ALL, Rating::STUDENT)->take(Rating::ALL);

        return view('teacher.rating.general-institute', compact('user', 'title', 'students'));
    }
}
