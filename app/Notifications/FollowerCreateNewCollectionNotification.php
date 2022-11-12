<?php

namespace App\Notifications;

use App\Http\Resources\CollectionResource;
use App\Models\Collection;
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

class FollowerCreateNewCollectionNotification extends Notification
{

    private User $user;
    private Collection $collection;

    public function __construct($collection, $user)
    {
        $this->collection = $collection;
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['database', FcmChannel::class, 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData(['data' => $this->collection])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('new Collection created')
                ->setBody($this->user->username . 'has created new Collection.')
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    public function toDatabase(mixed $notifiable): array
    {
        return [
            'title' => 'new Collection created',
            'message' => $this->user->username . 'has created new Collection',
            'collection' => CollectionResource::make($this->collection),
        ];
    }
}
