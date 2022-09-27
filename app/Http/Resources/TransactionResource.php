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
            'to' => $this->to, // UserResource::make($this->whenLoaded('to')),
            'from' => $this->from,// UserResource::make($this->whenLoaded('from')),
            'nft' => NftResource::make($this->whenLoaded('nft')),
            'price' => $this->price,
            'created_at' => $this->created_at
        ];
    }
}
