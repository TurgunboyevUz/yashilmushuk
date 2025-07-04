<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YouTube extends Model
{
    protected $table = 'you_tubes';

    protected $fillable = [
        'name',
        'url',
        'status',
    ];
}
