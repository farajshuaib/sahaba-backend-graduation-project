<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'username' => ['required', 'string', 'without_spaces'],
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
