<?php
namespace App\Models\Magazine;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(MagazineCategory::class, 'magazine_category_id');
    }
}
