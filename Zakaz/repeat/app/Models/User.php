<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'telegram_id' => 'integer',
        'balance' => 'float',
        'password'          => 'hashed',
    ];

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function exams()
    {
        return $this->hasMany(UserExam::class);
    }

    public function favourites()
    {
        return $this->hasMany(UserFavourite::class);
    }
}
