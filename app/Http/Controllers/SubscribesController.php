<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\SendEmailRequest;
use App\Http\Resources\SubscribeResource;
use App\Mail\NewsMail;
use App\Mail\SendEmail;
use App\Models\Subscribe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubscribesController extends Controller
{
    public function index()
    {
        try {
            $subscribers = Subscribe::query()->with('subscriber')->paginate(20);
            return response()->json([
                'data' => SubscribeResource::collection($subscribers),
                'meta' => PaginationMeta::getPaginationMeta($subscribers)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()
                ], 422);
            }

            if (Subscribe::query()->where('email', '=', $request->email)->exists())
                return response()->json(['message' => __('user_with_this_email_already_subscribed')], 403);

            Subscribe::query()->create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'email' => $request->email
            ]);

            return response()->json(['message' => __('thank_you_for_you_are_subscription')], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function sendEmail(SendEmailRequest $request)
    {
        try {
            $subscribers = Subscribe::query()->get();
            Mail::to($subscribers)->send(new NewsMail($request->validated()));
            return response()->json(['message' => 'email sent successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
