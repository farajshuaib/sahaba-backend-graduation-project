<?php

namespace App\Notifications;

use App\Http\Resources\NftResource;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class UserSetNftForSaleNotification extends Notification
{

    private User $user;
    private Nft $nft;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($nft, $user)
    {
        $this->nft = $nft;
        $this->user = $user;
    }

    public function via(mixed $notifiable): array
    {
        return ['database', FcmChannel::class, 'mail'];
    }

    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData(['data' => json_encode($this->nft)])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($this->nft->title . ' NFT now for sole')
                ->setBody($this->user->username . 'set NFT for sale.')
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->user->username . ' set ' . $this->nft->title . ' NFT for sale.')
            ->action('Preview', url('https://app.sahabanft.com.ly/nft-details/' . $this->nft->id))
            ->line('Thank you for using Sahabanft marketplace !!');
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'title' => 'NFT for sale',
            'message' => $this->user->username . 'has set NFT for sale',
            'nft' => NftResource::make($this->nft),
        ];
    }
}
