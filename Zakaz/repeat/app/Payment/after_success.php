<?php

use App\Models\Exam;
use App\Models\Package;
use App\Models\User;

if ($model instanceof Exam) {
    $user = User::find($transaction->user_id);
    $user->exams()->create(['exam_id' => $model->id]);
}

if ($model instanceof Package) {
    $user = User::find($transaction->user_id);
    $user->balance += $model->coins;
    $user->save();
}