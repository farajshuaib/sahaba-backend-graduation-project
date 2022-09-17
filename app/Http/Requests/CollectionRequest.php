<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'logo_image' => ['required', 'url'],
            'banner_image' => ['nullable', 'url'],
            'website_url' => ['nullable', 'url'],
            'facebook_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'telegram_url' => ['nullable', 'url'],
            'is_sensitive_content' => ['required', 'boolean'],
            'category_id' => ['required', 'int'],
        ];
    }
}
