<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocalLinksRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'facebook_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'telegram_url' => ['nullable', 'url'],
            'website_url' => ['nullable', 'url'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
