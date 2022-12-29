<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KycResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'address' => $this->address,
            'author_art_type' => $this->author_art_type,
            'author_type' => $this->author_type,
            'city' => $this->city,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'gender' => $this->gender,
            'id' => $this->id,
            'passport_id' => !!$this->getFirstMedia('passport_id') ? $this->getFirstMedia('passport_id')->getUrl() : null,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ];
    }

}
