<?php

namespace App\Notifications;

use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
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

    public function via(mixed $notifiable): array
    {
        return ['database', 'mail', FcmChannel::class];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('new Collection created.')
            ->action('preview', url('https://app.sahabanft.com.ly/collection/' . $this->collection->id))
            ->line($this->user->username . 'has created new Collection');
    }

    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData(['data' => json_encode($this->collection)])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('new Collection created')
                ->setBody($this->user->username . 'has created new Collection.')
            )
            ->setApns(
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
