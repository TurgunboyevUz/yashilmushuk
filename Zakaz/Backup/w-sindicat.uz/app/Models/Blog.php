<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasTranslationsFixed;

    protected $table = 'blogs';

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'body',
        'image', 'status',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'body' => 'array',
    ];

    public $translatable = [
        'title',
        'subtitle',
        'body',
    ];

    public function path()
    {
        return asset('storage/'.$this->image);
    }
}
