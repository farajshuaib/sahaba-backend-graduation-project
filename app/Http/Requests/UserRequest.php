<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . auth()->id()],
            'bio' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'image'],
            'website_url' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'string'],
            'twitter_url' => ['nullable', 'string'],
            'telegram_url' => ['nullable', 'string'],
        ];
    }

}
