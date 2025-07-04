<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrandEconomyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'criteria_id' => ['required', 'exists:criterias,id'],
            'title' => ['required', 'string', 'max:255'],
            'order_number' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'file' => ['required', 'file', 'mimes:pdf'],
        ];
    }
}
