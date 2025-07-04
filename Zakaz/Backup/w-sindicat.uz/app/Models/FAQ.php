<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasTranslationsFixed;

    protected $table = 'f_a_q_s';

    protected $fillable = [
        'question',
        'answer',
        'status',
    ];

    protected $casts = [
        'question' => 'array',
        'answer' => 'array',
    ];

    public $translatable = [
        'question',
        'answer',
    ];
}
