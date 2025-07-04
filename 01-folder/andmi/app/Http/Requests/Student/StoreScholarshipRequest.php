<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreScholarshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'criteria_id' => 'required|exists:criterias,id',
            'title' => 'required|string|max:255',
            'given_date' => 'required|date',
            'certificate_number' => 'required|string|max:255',
            'file' => 'required|mimes:pdf',
        ];
    }
}
