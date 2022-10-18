<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCollectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['required', 'string'],
            'is_sensitive_content' => ['required'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
