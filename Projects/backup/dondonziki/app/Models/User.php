<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'win', 'draw', 'lose', 'inline_win', 'inline_draw', 'inline_lose', 'mode'
    ];

    public $timestamps = false;
}