<?php

namespace App\Models;

use App\Models\Auth\Employee;
use App\Models\Auth\Gender;
use App\Models\Auth\Nation;
use App\Models\Auth\Student;
use App\Models\Chat\Chat;
use App\Models\File\Achievement;
use App\Models\File\Article;
use App\Models\File\DistinguishedScholarship;
use App\Models\File\File;
use App\Models\File\GrandEconomy;
use App\Models\File\Invention;
use App\Models\File\LangCertificate;
use App\Models\File\Olympic;
use App\Models\File\Scholarship;
use App\Models\File\Startup;
use App\Models\File\Task;
use App\Traits\Fileable;
use App\Traits\Scorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Fileable, HasFactory, HasRoles, Notifiable, Scorable;

    protected $guarded = [];

    protected static function booted()
    {
        //
    }

    public function full_name()
    {
        return $this->name.' '.$this->surname.' '.$this->patronymic;
    }

    public function fio()
    {
        return $this->surname.' '.$this->name.' '.$this->patronymic;
    }

    public function short_fio()
    {
        return $this->surname.' '.$this->name;
    }

    public function picture_path()
    {
        return asset('storage/'.$this->picture_path);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    public function inventions()
    {
        return $this->hasMany(Invention::class);
    }

    public function startups()
    {
        return $this->hasMany(Startup::class);
    }

    public function grand_economies()
    {
        return $this->hasMany(GrandEconomy::class);
    }

    public function olympics()
    {
        return $this->hasMany(Olympic::class);
    }

    public function lang_certificates()
    {
        return $this->hasMany(LangCertificate::class);
    }

    public function distinguished_scholarships()
    {
        return $this->hasMany(DistinguishedScholarship::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'student_id', 'id');
    }

    public function teacher_files()
    {
        return $this->hasMany(File::class, 'teacher_id', 'id');
    }

    public function student_files()
    {
        return $this->hasMany(File::class, 'uploaded_by', 'id');
    }
}
