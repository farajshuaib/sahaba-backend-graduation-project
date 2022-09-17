<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'image_url' => ['url', 'required'],
            'collection_id' => ['required', 'int'],
            'price' => ['required', 'numeric'],
            'sale_end_at' => ['nullable', 'date'],
            'is_for_sale' => ['required', 'boolean'],
        ];
    }
}
