<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)

    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'logo_image' => $this->logo_image,
            'banner_image' => $this->banner_image,
            'website_url' => $this->website_url,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'telegram_url' => $this->telegram_url,
            'is_sensitive_content' => $this->is_sensitive_content,
            'collection_token_id' => $this->collection_token_id,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'nfts' => NftResource::collection($this->whenLoaded('nfts')),
            'created_by' => UserResource::make($this->whenLoaded('user')),

        ];
    }
}
