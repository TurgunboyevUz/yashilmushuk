<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TurgunboyevUz\Mirpay\Traits\HasMirpayTransactions;

class Exam extends Model
{
    use HasMirpayTransactions;

    protected $guarded = [];

    protected $casts = [
        'is_free'    => 'boolean',
        'is_active'  => 'boolean',
        'price_uzs'  => 'integer',
        'price_coin' => 'integer',
    ];

    // -----------RELATIONSHIPS----------
    public function users()
    {
        return $this->hasMany(UserExam::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function favourites()
    {
        return $this->hasMany(UserFavourite::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'type', 'code');
    }

    public function parts()
    {
        return $this->hasMany(ExamPart::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function toggleFavourite(User $user)
    {
        if ($this->isFavourite($user)) {
            $this->favourites()->where('user_id', $user->id)->delete();
        } else {
            $this->favourites()->create([
                'user_id' => $user->id,
            ]);
        }

        return $this->isFavourite($user);
    }

    public function isPurchased(User $user)
    {
        return $this->users()->where('user_id', $user->id)->where('status', 'purchased')->exists();
    }

    public function isFavourite(User $user)
    {
        return $this->favourites()->where('user_id', $user->id)->exists();
    }
}
