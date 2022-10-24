<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => 'required|string',
            'message' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}