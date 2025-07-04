<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasTranslationsFixed;

    protected $table = 'catalogs';

    protected $fillable = [
        'slug',
        'name',
        'image',
        'status',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    public $translatable = [
        'name',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function path()
    {
        return asset('storage/'.$this->image);
    }
}
