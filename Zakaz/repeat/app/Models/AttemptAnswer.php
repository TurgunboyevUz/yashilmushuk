<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'score' => 'integer',
        'feedback' => 'array',
    ];

    protected $with = ['question'];

    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class);
    }
}
