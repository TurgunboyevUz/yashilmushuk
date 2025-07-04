<?php
namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Service\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function faculty(Request $request)
    {
        $user      = $request->user();
        $title     = "Fakultet reytingi";
        $employees = (new Rating($user, 'dean'))->getRating(Rating::FACULTY, Rating::TEACHER)->take(Rating::ALL);

        return view('dean.rating.faculty', compact('user', 'title', 'employees'));
    }

    public function institute(Request $request)
    {
        $user      = $request->user();
        $title     = "Institut reytingi";
        $employees = (new Rating($user))->getRating(Rating::ALL, Rating::TEACHER)->take(Rating::ALL);

        return view('dean.rating.institute', compact('user', 'title', 'employees'));
    }

    public function general_faculty(Request $request)
    {
        $user     = $request->user();
        $title    = "Talabalarni fakultet bo'yicha umumiy reytingi";
        $students = (new Rating($user, 'dean'))->getRating(Rating::FACULTY, Rating::STUDENT)->take(Rating::ALL);

        return view('dean.rating.general-faculty', compact('user', 'title', 'students'));
    }

    public function general_institute(Request $request)
    {
        $user     = $request->user();
        $title    = "Talabalarni institut bo'yicha umumiy reytingi";
        $students = (new Rating($user))->getRating(Rating::ALL, Rating::STUDENT)->take(Rating::ALL);

        return view('dean.rating.general-institute', compact('user', 'title', 'students'));
    }
}
