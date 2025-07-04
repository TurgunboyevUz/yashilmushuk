<?php

namespace App\Models\Scopes;

use App\Models\File\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FileEducationYearScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (method_exists($model, 'files')) {
            $builder->whereHas('files.education_year', function ($query) {
                $query->where('is_current', true);
            });
        }

        if (method_exists($model, 'file')) {
            $builder->whereHas('file.education_year', function ($query) {
                $query->where('is_current', true);
            });
        }

        if ($model instanceof File) {
            $builder->whereHas('education_year', function ($query) {
                $query->where('is_current', true);
            });
        }
    }
}
