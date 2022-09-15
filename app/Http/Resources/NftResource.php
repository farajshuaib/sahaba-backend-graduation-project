<?php

namespace App\Http\Resources;

use App\Models\Nft;
use Illuminate\Http\Resources\Json\JsonResource;

class NftResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'creator_address' => $this->creator_address,
            'owner_address' => $this->owner_address,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'category' => CategoryResource::make($this->category),
            'collection' => CollectionResource::make($this->collection),
            'price' => $this->price,
            'like_count' => $this->likeCount,
            'sale_end_at' => $this->sale_end_at,
            'is_for_sale' => $this->is_for_sale,
            'transfers_count' => $this->transfers_count,
            'status' => $this->status,
            $this->mergeWhen(auth()->check(), function () {
                return ['is_liked' => $this->liked()];
            }),
        ];
    }
}
