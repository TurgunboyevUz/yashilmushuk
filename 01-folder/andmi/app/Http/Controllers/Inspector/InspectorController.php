<?php

namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inspector\StoreCriteriaRequest;
use App\Http\Requests\Inspector\StoreProfileRequest;
use App\Models\Criteria\Criteria;

class InspectorController extends Controller
{
    public function edit_profile(StoreProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update([
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $this->toast('Profil muvaffaqiyatli yangilandi!');

        return redirect()->route($request->route()->getName());
    }

    public function evaluation_criteria(StoreCriteriaRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        foreach ($data['score'] as $id => $value) {
            $criteria = Criteria::find($id);
            $criteria->update([
                'score' => $value,
            ]);
        }

        $this->toast('Baholash mezoni muvaffaqiyatli o\'zgartirildi');

        return redirect()->back();
    }

    public function toast($message)
    {
        toast($message, 'success', 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }
}
