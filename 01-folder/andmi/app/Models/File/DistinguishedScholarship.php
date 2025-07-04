<?php

namespace App\Models\File;

use App\Models\User;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class DistinguishedScholarship extends Model
{
    use Fileable;

    protected $guarded = [];

    public function user_id()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
