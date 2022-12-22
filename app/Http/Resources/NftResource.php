<?php

namespace App\Http\Resources;

use App\Models\Nft;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Nft */
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
            'price' => $this->price,
            'like_count' => $this->likers()->count(),
            'watch_time' => $this->watchers()->count(),
            'is_for_sale' => $this->is_for_sale,
            $this->mergeWhen($this->is_for_sale, function () {
                return ['sale_end_at' => $this->whenLoaded('sale_end_at')];
            }),
            $this->mergeWhen(auth()->check() && (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('super-admin')), function () use ($currentNft) {
                return ['is_liked' => auth()->user()->hasLiked($currentNft)];
            }),
            'collection' => CollectionResource::make($this->whenLoaded('collection')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'owner' => UserResource::make($this->whenLoaded('owner')),
            'created_at' => $this->created_at,
            'status' => $this->status,
        ];
    }
}
