<?php

namespace App\Models\File;

use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use Fileable;

    protected $guarded = [];
}
