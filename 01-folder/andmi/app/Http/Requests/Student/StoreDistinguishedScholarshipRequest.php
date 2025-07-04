<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistinguishedScholarshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference' => 'required|file|mimes:pdf',
            'passport' => 'required|file|mimes:pdf',
            'rating_book' => 'required|file|mimes:pdf',
            'dean_guarantee' => 'required|file|mimes:pdf',
            'dean_recommendation' => 'required|file|mimes:pdf',
            'faculty_statement' => 'required|file|mimes:pdf',
            'department_recommendation' => 'required|file|mimes:pdf',
            'supervisor_conclusion' => 'required|file|mimes:pdf',
            'list_of_works' => 'required|file|mimes:pdf',
            'certificates' => 'required|file|mimes:pdf',
        ];
    }
}
