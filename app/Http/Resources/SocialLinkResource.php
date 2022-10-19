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
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twiiter_url,
            'instagram_url' => $this->instagram_url,
            'telegram_url' => $this->telegram_url,
            'website_url' => $this->website_url,
        ];
    }
}
