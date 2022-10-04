<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Kyc_Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'gender' => ['string', 'required'],
            'country' => ['string', 'required'],
            'city' => ['string', 'required'],
            'address' => ['string', 'required'],
            'phone_number' => ['string', 'required'],
            'author_type' => ['string', 'required'],
            'author_art_type' => ['string', 'required'],
            'passport_id' => ['file', 'required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
