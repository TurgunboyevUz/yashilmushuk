<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'criteria_id' => 'required|exists:criterias,id',
            'education_year' => 'required|exists:education_years,id',
            'title' => 'required|string|max:255',
            'keywords' => 'required|string',
            'lang' => 'required|in:uz,ru,en',
            'authors_count' => 'required|integer|min:1',
            'authors' => 'required|string',
            'doi' => 'required|string',
            'journal_name' => 'required|string',
            'publish_params' => 'required|string',
            'international_databases' => 'required|string',
            'published_year' => 'required|integer|min:1900|max:2100',
            'file' => 'required|mimes:pdf',
        ];
    }
}
