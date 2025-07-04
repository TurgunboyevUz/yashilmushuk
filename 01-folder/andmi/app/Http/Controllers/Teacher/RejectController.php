<?php

namespace App\Http\Controllers\Teacher;

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

class RejectController extends Controller
{
    public function article(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:articles,id',
            'reason' => 'required|string',
        ]);

        $article = Article::find($data['id']);
        $article->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Maqola');

        return response()->json([
            'message' => 'Rad etildi',
        ]);
    }

    public function scholarship(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:scholarships,id',
            'reason' => 'required|string',
        ]);

        $scholarship = Scholarship::find($data['id']);
        $scholarship->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Stipendiyat');

        return response()->json([
            'message' => 'Rad etildi',
        ]);
    }

    public function invention(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:inventions,id',
            'reason' => 'required|string',
        ]);

        $invention = Invention::find($data['id']);
        $invention->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Ixtiro');

        return response()->json([
            'message' => 'Rad etildi',
        ]);
    }

    public function startup(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:startups,id',
            'reason' => 'required|string',
        ]);

        $startup = Startup::find($data['id']);
        $startup->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Startup');

        return response()->json([
            'message' => 'Rad etildi',
        ]);
    }

    public function grand_economy(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:grand_economies,id',
            'reason' => 'required|string',
        ]);

        $grand = GrandEconomy::find($data['id']);
        $grand->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Shartnoma');

        return response()->json([
            'message' => 'Rad etildi',
        ]);
    }

    public function olympics(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:olympics,id',
            'reason' => 'required|string',
        ]);

        $olympic = Olympic::find($data['id']);
        $olympic->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Olimpiada');

        return response()->json([
            'message' => 'Rad etildi',
        ]);
    }

    public function lang_certificate(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:lang_certificates,id',
            'reason' => 'required|string',
        ]);

        $lang = LangCertificate::find($data['id']);
        $lang->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Til sertifikati');

        return response()->json([
            'message' => 'Rad etildi!',
        ]);
    }

    public function achievement(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:achievements,id',
            'reason' => 'required|string',
        ]);

        $achievement = Achievement::find($data['id']);
        $achievement->file()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Yutuqlar');

        return response()->json([
            'message' => 'Rad etildi!',
        ]);
    }

    public function toast($file_type)
    {
        toast($file_type.' rad etildi!', 'info', 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }
}
