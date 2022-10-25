<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendResetLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:admins,email',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}