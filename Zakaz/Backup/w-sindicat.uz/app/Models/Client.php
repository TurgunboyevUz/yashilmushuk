<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['name', 'image', 'status'];

    public function path()
    {
        return asset('storage/'.$this->image);
    }
}
