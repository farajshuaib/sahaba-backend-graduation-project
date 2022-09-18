<?php

namespace App\Http\Resources;

use App\Models\Nft;
use Illuminate\Http\Resources\Json\JsonResource;

class NftResource extends JsonResource
{
    public function toArray($request): array
    {
        $currentNft = Nft::where('id', $this->id)->first();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'creator_address' => $this->creator_address,
            'description' => $this->description,
            'file_url' => $this->file_url,
            'file_type' => $this->file_type,
            'collection' => CollectionResource::make($this->collection),
            'user' => UserResource::make($this->whenLoaded('user')),
            'price' => $this->price,
            'like_count' => $currentNft->likers()->count(),
            'is_for_sale' => $this->is_for_sale,
            'nft_token_id' => $this->nft_token_id,
//            'transfers_count' => $this->transfers_count,
            $this->mergeWhen($this->is_for_sale, function () {
                return ['sale_end_at' => $this->sale_end_at];
            }),
            $this->mergeWhen(auth()->check(), function () use ($currentNft) {
                return ['is_liked' => auth()->user()->hasLiked($currentNft)];
            }),
        ];
    }
}
