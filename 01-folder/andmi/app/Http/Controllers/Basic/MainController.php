<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\File\File;
use Illuminate\Http\Request;
use ZipArchive;

class MainController extends Controller
{
    public function welcome(Request $request)
    {
        return view('welcome');
    }

    public function locale(Request $request)
    {
        $user = $request->user();
        $user->update(['locale' => $request->query('locale')]);

        return redirect()->back();
    }
}
