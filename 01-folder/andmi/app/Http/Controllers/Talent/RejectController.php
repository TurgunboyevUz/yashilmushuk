<?php

namespace App\Http\Controllers\Talent;

use App\Http\Controllers\Controller;
use App\Models\File\DistinguishedScholarship;
use Illuminate\Http\Request;

class RejectController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:distinguished_scholarships,id',
            'reason' => 'required|string',
        ]);

        $item = DistinguishedScholarship::find($data['id']);
        $item->files()->update([
            'status' => 'rejected',
            'reject_reason' => $data['reason'],
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
        ]);

        $this->toast('Ariza');

        return response()->json([
            'message' => 'Rad etildi',
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
