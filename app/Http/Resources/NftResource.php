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
            'description' => $this->description,
            'file_path' => $this->file_path,
            'file_type' => $this->file_type,
            'collection' => CollectionResource::make($this->whenLoaded('collection')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'price' => $this->price,
            'like_count' => $currentNft->likers()->count(),
            'is_for_sale' => $this->is_for_sale,
            'token_id' => $this->token_id,
            'owner' => UserResource::make($this->whenLoaded('owner')),
            'watch_time' => $this->watchers()->count(),
            'transactions' => $this->transactions->load('from', 'to'), //TransactionResource::collection($this->transactions->load('from', 'to')),
            $this->mergeWhen($this->is_for_sale, function () {
                return ['sale_end_at' => $this->sale_end_at];
            }),
            $this->mergeWhen(auth()->check(), function () use ($currentNft) {
                return ['is_liked' => auth()->user()->hasLiked($currentNft)];
            }),
        ];
    }
}
