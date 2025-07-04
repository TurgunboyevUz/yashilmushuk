<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreLangCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'criteria_id' => 'required|exists:criterias,id',
            'lang' => 'required|in:ru,en,de',
            'type' => 'required|in:national,cambridge,toefl-itp,toefl-ibt,ielts,itep',
            'given_date' => 'required|date',
            'file' => 'required|file|mimes:pdf',
        ];
    }
}
