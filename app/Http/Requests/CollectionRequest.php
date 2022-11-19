<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'unique:collections'],
            'name' => ['required'],
            'description' => ['required', 'string'],
            'logo_image' => ['required', 'image'],
            'banner_image' => ['nullable', 'image'],
            'is_sensitive_content' => ['required'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'blockchain_id' => ['required', Rule::exists('blockchains', 'id')],
        ];
    }
}
