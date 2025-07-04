<?php
namespace App\Traits;

use App\Models\Criteria\Criteria;
use App\Models\Criteria\EducationYear;
use App\Models\File\File;
use App\Models\Scopes\FileEducationYearScope;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait Fileable
{
    protected static function booted()
    {
        static::addGlobalScope(new FileEducationYearScope());
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function education_year()
    {
        return $this->file->education_year;
    }

    public function status()
    {
        $statuses = [
            'pending'  => [
                'name'  => 'Kutilmoqda',
                'color' => 'warning',
            ],
            'reviewed' => [
                'name'  => 'Tasdiqlanmoqda',
                'color' => 'info',
            ],
            'approved' => [
                'name'  => 'Tasdiqlandi',
                'color' => 'success',
            ],
            'rejected' => [
                'name'  => 'Rad etildi',
                'color' => 'danger',
            ],
        ];

        return $statuses[$this->file->status];
    }

    public function upload_file(Request $request, $directory = null, $key = 'file')
    {
        $file = $request->file($key);
        $name = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();

        try {
            $path = $file->store($directory, 'public');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        $edu_year = EducationYear::where('is_current', true)->first();

        return $this->file()->create([
            'uuid'              => (string) Str::uuid(),
            'name'              => $name,
            'path'              => $path,
            'mime_type'         => $mime,
            'size'              => $file->getSize(),
            'type'              => $key,
            'uploaded_by'       => $request->user()->id,

            'education_year_id' => $edu_year->id,
        ]);
    }
}
