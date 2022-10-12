<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request): array
    {
        $currentUser = User::where('id', $this->id)->first();
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'bio' => $this->bio,
            'wallet_address' => $this->wallet_address,
            'profile_photo' => !!$this->getFirstMedia('users_profile') ? $this->getFirstMedia('users_profile')->getUrl() : null,
            'website_url' => $this->website_url,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'telegram_url' => $this->telegram_url,
            'is_verified' => $this->is_verified,
            'created_nfts_count' => $this->created_nfts_count,
            'owned_nfts_count' => $this->owned_nfts_count,
            'is_subscribed' => $this->subscribe()->exists(),
            'kyc_form' => $this->whenLoaded('kyc'),
            $this->mergeWhen(auth()->check(), function () use ($currentUser) {
                return ['is_followed' => auth()->user()->isFollowing($currentUser)];
            }),
        ];
    }
}
