<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'bio' => $this->bio,
            'wallet_address' => $this->wallet_address,
            'profile_photo' => $this->profile_photo,
            'website_url' => $this->website_url,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'telegram_url' => $this->telegram_url,
            'is_verified' => $this->is_verified,
//            'collections' => CollectionResource::collection($this->whenLoaded('collections')),
//            'nfts' => NftResource::collection($this->whenLoaded('nfts')),
//            'liked_nfts' => LikedNftsResource::collection($this->whenLoaded('likes')),
        ];
    }
}
