<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['string', 'required'],
            'email' => ['string', 'required', 'unique:admins,email'],
            'password' => ['string', 'required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
