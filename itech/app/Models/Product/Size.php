<?php
namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Price::class, 'size_id');
    }
}
