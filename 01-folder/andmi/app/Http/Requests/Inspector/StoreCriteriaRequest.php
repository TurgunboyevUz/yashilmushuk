<?php

namespace App\Http\Requests\Inspector;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriteriaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        foreach ($this->input('score', []) as $criteria_id => $score) {
            $rules["score.$criteria_id"] = 'required|numeric|min:0|max:100';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'score.*.required' => 'Ball maydoni to\'ldirilishi shart!',
            'score.*.numeric' => 'Ball faqat raqam bo\'lishi kerak!',
            'score.*.min' => 'Ball manfiy bo\'lmasligi kerak!',
            'score.*.max' => 'Ball maksimal 100 bo\'lishi kerak!',
        ];
    }
}
