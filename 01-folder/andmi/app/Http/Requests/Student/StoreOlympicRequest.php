<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreOlympicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'criteria_id' => 'required|exists:criterias,id',
            'date' => 'required|date',
            'direction' => 'required|string',
            'file' => 'required|file|mimes:pdf',
        ];
    }
}
