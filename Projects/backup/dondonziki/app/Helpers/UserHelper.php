<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserHelper
{
    public static $id;
    public static $user;

    public static function set($id)
    {
        static::$id = $id;
    }

    public static function user()
    {
        if(!isset(static::$user) or static::$user->user_id != static::$id)
        {
            static::$user = User::firstOrCreate(['user_id' => static::$id]);
        }

        return static::$user;
    }

    public static function save($name, $value)
    {
        return Cache::put($name, $value, now()->addDay());
    }

    public static function get($name)
    {
        return Cache::get($name);
    }

    public static function has($name)
    {
        return Cache::has($name);
    }

    public static function delete($name)
    {
        return Cache::forget($name);
    }

    public static function win()
    {
        User::where('user_id', static::$id)->increment('win');
    }

    public static function draw()
    {
        User::where('user_id', static::$id)->increment('draw');
    }

    public static function lose()
    {
        User::where('user_id', static::$id)->increment('lose');
    }

    public static function inlineWin()
    {
        User::where('user_id', static::$id)->increment('inline_win');
    }

    public static function inlineDraw()
    {
        User::where('user_id', static::$id)->increment('inline_draw');
    }

    public static function inlineLose()
    {
        User::where('user_id', static::$id)->increment('inline_lose');
    }
}

?>