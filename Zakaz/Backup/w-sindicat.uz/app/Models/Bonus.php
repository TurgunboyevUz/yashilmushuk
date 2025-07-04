<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasTranslationsFixed;

    protected $table = 'bonuses';

    protected $fillable = ['name', 'description', 'image', 'status'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    public $translatable = ['name', 'description'];

    public function path()
    {
        return asset('storage/'.$this->image);
    }
}
