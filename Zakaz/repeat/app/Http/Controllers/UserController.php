<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ExamResource;
use App\Http\Resources\UserExamResource;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Foydalanuvchi')]
class UserController extends Controller
{
    use HttpResponse;

    /**
     * Profilni olish
     */
    public function profile(Request $request) {
        return $this->success(new UserResource($request->user()));
    }

    /**
     * Profilni o'zgartirish
     */
    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();

        if($request->has('avatar')) {
            $path = $request->file('avatar')->store('public/avatars');
            $data['avatar'] = $path;
        }

        $request->user()->update($data);

        return $this->success(new UserResource($request->user()), message: 'Profile updated successfully');
    }

    /**
     * Sevimlilar ro'yxati
     */
    public function favourites(Request $request) {
        return $this->success(ExamResource::collection($request->user()->favourites()->with('exam')->get()));
    }

    /**
     * Imtihonlar ro'yxati
     */
    public function exams(Request $request) {
        $request->validate([
            // Imtihon statusi (purchased - sotib olingan, completed - tugatilgan)
            'status' => 'nullable|in:purchased,completed'
        ]);

        $exams = $request->user->exams()->with('exam');

        if ($request->filled('status')) {
            $exams = $exams->where('status', $request->status);
        }

        $exams = $exams->get();

        return $this->success(UserExamResource::collection($exams));
    }
}
