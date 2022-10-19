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


    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name ?? "",
            'description' => $this->description ?? "",
            'logo_image' => $this->getFirstMedia('collection_logo_image') ? $this->getFirstMedia('collection_logo_image')->getUrl() : "",
            'banner_image' => $this->getFirstMedia('collection_banner_image') ? $this->getFirstMedia('collection_banner_image')->getUrl() : "",
            'is_sensitive_content' => $this->is_sensitive_content,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'nfts' => NftResource::collection($this->whenLoaded('nfts')),
            'created_by' => UserResource::make($this->whenLoaded('user')),
            'nfts_count' => $this->nfts()->count(),
            'volume' => $this->nfts()->sum('price'),
            'min_price' => $this->nfts()->min('price'),
            'max_price' => $this->nfts()->max('price'),
            'collaborators' => $this->collaborators,
            'social_links' => SocialLinkResource::make($this->whenLoaded('socialLinks')),
        ];
    }
}
