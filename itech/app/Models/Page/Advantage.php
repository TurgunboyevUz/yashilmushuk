<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    protected $guarded = [];
    protected $casts = [
        'status' => 'boolean'
    ];
}
