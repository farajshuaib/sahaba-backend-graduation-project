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
            'email' => ['required', 'string'],
            'bio' => ['required', 'string'],
            'profile_photo' =>['required', 'string'],
            'website_url' => [ 'string'],
            'facebook_url' => [ 'string'],
            'twitter_url' => [ 'string'],
            'telegram_url' => [ 'string'],
        ];
    }
}
