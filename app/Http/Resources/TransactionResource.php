<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'seller' => UserResource::make($this->whenLoaded('seller')),
            'buyer' => UserResource::make($this->whenLoaded('buyer')),
            'nft' => NftResource::make($this->whenLoaded('nft'))
        ];
    }
}
