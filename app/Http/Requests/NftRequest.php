<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NftRequest extends FormRequest
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
            'title' => ['string', 'required'],
            'description' => ['string', 'required'],
            'file_path' => ['string', 'required'],
            'token_id' => ['required', 'string'],
            'collection_id' => ['required', 'int', Rule::exists('collections', 'id')],
            'price' => ['required', 'numeric'],
        ];
    }
}
