<?php

namespace App\Models\File;

use App\Models\Auth\Location;
use App\Models\User;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use Fileable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
        $arr = ['sport' => 'Sport', 'cultural' => "Ma'naviy-ma'rifiy ishlar"];

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

    public function document_type()
    {
        $arr = ['certificate' => 'Sertifikat', 'diploma' => 'Diplom'];

        return $arr[$this->document_type];
    }
}
