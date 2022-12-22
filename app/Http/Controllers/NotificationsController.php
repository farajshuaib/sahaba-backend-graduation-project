<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Exception;

class NotificationsController extends Controller
{
    public function index()
    {
        try {
            $notifications = auth()->user()->notifications()->paginate(10);
            return NotificationResource::collection($notifications);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function markAsRead($id)
    {
        try {
            $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();
            if (!$notification->read_at) {
                $notification->read_at = now();
                $notification->save();
            }
            return NotificationResource::make($notification);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $notifications = auth()->user()->notifications()->whereNull('read_at')->get();
            foreach ($notifications as $notification) {
                $notification->read_at = now();
                $notification->save();
            }
            return NotificationResource::collection($notifications);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
