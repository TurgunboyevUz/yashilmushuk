<?php

namespace App\Models;

use App\Traits\HasTranslationsFixed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

class Product extends Model
{
    use HasTranslationsFixed;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'color',
        'code',
        'images',
        'category_id',
        'status',
        'custom_url',
        'custom_text',
        'is_available',
        'brands',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'color' => 'array',
        'price' => 'integer',
        'images' => 'array',
        'custom_text' => 'array',
        'brands' => 'array',
    ];

    public $translatable = ['name', 'description', 'color', 'custom_text'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function price_formatted()
    {
        return $this->price ? number_format($this->price, 0, ',', ' ').'UZS' : __('catalog.clarify');
    }

    public function path()
    {
        return asset('storage/'.$this->images[0]);
    }

    public function getUrlAttribute()
    {
        if (! $this->custom_url) {
            $data = View::getShared();
            $url = $data['contact_button']['url'];

            return $url;
        }

        return $this->custom_url;
    }

    public function getTextAttribute()
    {
        if (! $this->custom_text) {
            $replacements = [
                'code' => $this->code,
                'color' => $this->color,
                'size' => $this->size,
                'name' => $this->name,
            ];

            $text = __('catalog.product_text', $replacements);

            return ucfirst(trim($text));
        }

        return $this->custom_text;
    }
}
