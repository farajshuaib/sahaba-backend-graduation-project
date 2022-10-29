<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::withFilters()->paginate(10);
        return NotificationResource::collection($notifications);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();
        if (!$notification->read_at) {
            $notification->read_at = now();
            $notification->save();
        }
        return NotificationResource::make($notification);
    }

    public function markAllAsRead()
    {
        $notifications = auth()->user()->notifications()->whereNull('read_at')->get();
        foreach ($notifications as $notification) {
            $notification->read_at = now();
            $notification->save();
        }
        return NotificationResource::collection($notifications);
    }

}
