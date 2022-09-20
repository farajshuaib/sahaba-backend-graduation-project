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
            'name' => ['required'],
            'description' => ['required', 'string'],
            'logo_image' => ['required', 'string'],
            'banner_image' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url'],
            'facebook_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'is_sensitive_content' => ['required', 'boolean'],
            'collection_token_id' => ['required', 'int'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'user_id' => ['required', Rule::exists('users', 'id')],
        ];
    }
}
