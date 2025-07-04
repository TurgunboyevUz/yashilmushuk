<?php

namespace App\Models\File;

use App\Models\Auth\Location;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    use Fileable;

    protected $guarded = [];

    public function team_members()
    {
        if ($this->participant == 'team') {
            return $this->team_members;
        } else {
            return $this->file->user->fio();
        }
    }

    public function type()
    {
        $arr = ['startup' => 'StartUp', 'contest' => 'Contest'];

        return $arr[$this->type];
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getLocation()
    {
        return $this->location->name;
    }
}
