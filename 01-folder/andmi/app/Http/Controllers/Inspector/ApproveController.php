<?php

namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Models\File\Achievement;
use App\Models\File\Article;
use App\Models\File\GrandEconomy;
use App\Models\File\Invention;
use App\Models\File\LangCertificate;
use App\Models\File\Olympic;
use App\Models\File\Scholarship;
use App\Models\File\Startup;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    public function article(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:articles,id',
        ]);

        $article = Article::find($data['id']);
        $article->file()->update([
            'student_score' => $article->criteria->score,
            'teacher_score' => $article->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Maqola');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function scholarship(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:scholarships,id',
        ]);

        $scholarship = Scholarship::find($data['id']);
        $scholarship->file()->update([
            'student_score' => $scholarship->criteria->score,
            'teacher_score' => $scholarship->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Stipendiya');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function invention(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:inventions,id',
        ]);

        $invention = Invention::find($data['id']);
        $invention->file()->update([
            'student_score' => $invention->criteria->score,
            'teacher_score' => $invention->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Ixtiro');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function startup(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:startups,id',
        ]);

        $startup = Startup::find($data['id']);
        $startup->file()->update([
            'student_score' => $startup->criteria->score,
            'teacher_score' => $startup->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Startap');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function grand_economy(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:grand_economies,id',
        ]);

        $grand = GrandEconomy::find($data['id']);
        $grand->file()->update([
            'student_score' => $grand->criteria->score,
            'teacher_score' => $grand->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Katta iqtisodiy');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function olympics(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:olympics,id',
        ]);

        $olympic = Olympic::find($data['id']);
        $olympic->file()->update([
            'student_score' => $olympic->criteria->score,
            'teacher_score' => $olympic->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Olimpiada');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function lang_certificate(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:lang_certificates,id',
        ]);

        $lang = LangCertificate::find($data['id']);
        $lang->file()->update([
            'student_score' => $lang->criteria->score,
            'teacher_score' => $lang->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Til sertifikati');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function achievement(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:achievements,id',
        ]);

        $achievement = Achievement::find($data['id']);
        $achievement->file()->update([
            'student_score' => $achievement->criteria->score,
            'teacher_score' => $achievement->criteria->score,
            'status' => 'approved',
            'inspector_id' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->toast('Yutuq');

        return response()->json([
            'message' => 'Tasdiqlandi',
        ]);
    }

    public function toast($file_type)
    {
        toast($file_type.' tasdiqlandi!', 'success', 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }
}
