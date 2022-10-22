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
            'to' => $this->toUser, //UserResource::make($this->whenLoaded('toUser')), // UserResource::make($this->whenLoaded('to')),
            'from' => $this->fromUser, // UserResource::make($this->whenLoaded('fromUser')), // UserResource::make($this->whenLoaded('to')),
            'nft' => NftResource::make($this->whenLoaded('nft')),
            'price' => $this->price,
            'type' => $this->type,
            'created_at' => $this->created_at
        ];
    }
}
