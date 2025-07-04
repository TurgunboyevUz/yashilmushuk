<?php

namespace App\Http\Requests\Dean;

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
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ];
    }
}
