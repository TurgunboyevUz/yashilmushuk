<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'argument_list' => 'array'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function part()
    {
        return $this->belongsTo(ExamPart::class);
    }
}
