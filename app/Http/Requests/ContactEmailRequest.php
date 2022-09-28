<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
