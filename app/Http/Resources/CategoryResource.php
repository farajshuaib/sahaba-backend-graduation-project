<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use JsonSerializable;

class CategoryResource extends JsonResource
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
            'name' => App::getLocale() == 'ar' ? $this->name_ar : $this->name_en,
            'icon' => $this->getFirstMedia('category_icon') ? $this->getFirstMedia('category_icon')->getUrl() : null,
            'collections_count' => $this->whenLoaded('collections_count'),
            'nfts_count' => $this->whenLoaded('nfts_count'),
        ];
    }
}
