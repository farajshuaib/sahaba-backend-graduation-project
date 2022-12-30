<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialLinkResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'facebook_url' => $this->whenLoaded('facebook_url'),
            'twitter_url' => $this->whenLoaded('twitter_url'),
            'instagram_url' => $this->whenLoaded('instagram_url'),
            'telegram_url' => $this->whenLoaded('telegram_url'),
            'website_url' => $this->whenLoaded('website_url'),
        ];
    }
}
