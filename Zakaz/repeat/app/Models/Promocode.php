<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $guarded = [];

    protected $casts = [
        'discount_percentage' => 'integer',
        'discount_uzs'        => 'integer',
        'discount_coin'       => 'integer',
        'usage_limit'         => 'integer',
        'used_count'          => 'integer',
        'valid_from'          => 'datetime',
        'valid_until'         => 'datetime',
        'is_active'           => 'boolean',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // -----------SCOPES----------
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
