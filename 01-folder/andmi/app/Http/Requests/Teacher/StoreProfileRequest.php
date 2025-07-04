<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'faculty_id' => 'required|exists:departments,id',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ];
    }
}
