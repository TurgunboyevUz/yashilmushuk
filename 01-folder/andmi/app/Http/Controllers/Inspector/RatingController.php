<?php
namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Service\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function institute(Request $request)
    {
        $user      = $request->user();
        $title = "Institut reytingi";
        $employees = (new Rating($user))->getRating(Rating::ALL, Rating::TEACHER)->take(Rating::ALL);

        return view('inspeksiya.rating.institute', compact('user', 'title', 'employees'));
    }

    public function general_institute(Request $request)
    {
        $user = $request->user();
        $title = "Talabalarning institut bo'yicha umumiy reytingi";
        $students = (new Rating($user))->getRating(Rating::ALL, Rating::STUDENT)->take(Rating::ALL);

        return view('inspeksiya.rating.general-institute', compact('user', 'title', 'students'));
    }
}
