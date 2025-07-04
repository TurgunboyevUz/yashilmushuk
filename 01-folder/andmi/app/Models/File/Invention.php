<?php

namespace App\Models\File;

use App\Models\Criteria\EducationYear;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class Invention extends Model
{
    use Fileable;

    protected $guarded = [];

    public function education_year()
    {
        return $this->belongsTo(EducationYear::class);
    }
}
