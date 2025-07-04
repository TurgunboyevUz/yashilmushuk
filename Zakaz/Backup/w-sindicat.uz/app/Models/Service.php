<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasTranslationsFixed;

    protected $table = 'services';

    protected $fillable = [
        'slug',
        'name',
        'title',
        'body',
        'image',
        'status',
    ];

    protected $casts = [
        'name' => 'array',
        'title' => 'array',
        'body' => 'array',
    ];

    public $translatable = [
        'name',
        'title',
        'body',
    ];

    public function path()
    {
        return asset('storage/'.$this->image);
    }
}
