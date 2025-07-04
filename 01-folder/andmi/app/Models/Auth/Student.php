<?php

namespace App\Models\Auth;

use App\Models\File\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Department::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function articles()
    {
        return $this->user->articles();
    }

    public function achievements()
    {
        return $this->user->achievements();
    }

    public function inventions()
    {
        return $this->user->inventions();
    }

    public function olympics()
    {
        return $this->user->olympics();
    }

    public function scholarships()
    {
        return $this->user->scholarships();
    }

    public function startups()
    {
        return $this->user->startups();
    }

    public function lang_certificates()
    {
        return $this->user->lang_certificates();
    }

    public function distinguished_scholarships()
    {
        return $this->user->distinguished_scholarships();
    }

    public function grand_economies()
    {
        return $this->user->grand_economies();
    }
}
