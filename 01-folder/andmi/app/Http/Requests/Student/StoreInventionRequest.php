<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'criteria_id' => ['required', 'exists:criterias,id'],
            'education_year' => ['required', 'exists:education_years,id'],
            'title' => ['required', 'string'],
            'property_number' => ['required', 'string'],
            'authors_count' => ['required', 'integer'],
            'authors' => ['required', 'string'],
            'publish_params' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:pdf'],
        ];
    }
}
