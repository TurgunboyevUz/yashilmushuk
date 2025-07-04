<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasTranslationsFixed;

    protected $table = 'categories';

    protected $fillable = [
        'slug',
        'name',
        'description',
        'catalog_id',
        'status',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    public $translatable = [
        'name',
        'description',
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
