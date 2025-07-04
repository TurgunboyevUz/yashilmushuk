<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'count'
    ];

    public $timestamps = false;

    public static function game(){
        $game = self::firstOrCreate(['type' => 'game']);
        $game->count = $game->count + 1;
        $game->save();
    }

    public static function inline(){
        $game = self::firstOrCreate(['type' => 'inline']);
        $game->count = $game->count + 1;
        $game->save();
    }
}