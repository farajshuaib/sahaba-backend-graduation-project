<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionCollaboratorRequest extends FormRequest
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
            'wallet_address' => ['string', 'required', Rule::exists('users', 'wallet_address')],
            'collection_id' => ['integer', 'required', Rule::exists('collections', 'id')],
        ];
    }
}
