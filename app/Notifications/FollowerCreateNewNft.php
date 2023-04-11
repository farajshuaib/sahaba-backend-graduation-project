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


class FollowerCreateNewNft extends Notification
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

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database', 'mail', FcmChannel::class];
    }


    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData(['data' => json_encode($this->nft)])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('new NFT created')
                ->setBody($this->user->username . 'has created new NFT.')
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line($this->user->username . 'has created new NFT. it\'s call ' . $this->nft->title)
            ->action('Preview', url('https://app.sahabanft.com.ly/nft-details/' . $this->nft->id))
            ->line('Thank you for using Sahabanft marketplace !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'title' => 'new NFT created',
            'message' => $this->user->username . 'has created new NFT',
            'nft' => NftResource::make($this->nft),
        ];
    }
}
