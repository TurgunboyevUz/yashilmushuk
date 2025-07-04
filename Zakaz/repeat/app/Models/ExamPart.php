<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamPart extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
