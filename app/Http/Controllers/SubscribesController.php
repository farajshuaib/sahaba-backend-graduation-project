<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\SendEmailRequest;
use App\Http\Resources\SubscribeResource;
use App\Mail\NewsMail;
use App\Mail\SendEmail;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubscribesController extends Controller
{
    public function index()
    {
        $subscribers = Subscribe::query()->with('subscriber')->paginate(20);
        return response()->json([
            'data' => SubscribeResource::collection($subscribers),
            'meta' => PaginationMeta::getPaginationMeta($subscribers)]);
    }

    public function store(Request $request)
    {
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
            return response()->json(['message' => 'user with this email already subscribed'], 403);

        Subscribe::query()->create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'email' => $request->email
        ]);

        return response()->json(['message' => 'thank you for you\'re subscription '], 200);
    }

    public function sendEmail(SendEmailRequest $request)
    {

        $subscribers = Subscribe::query()->get();
        Mail::to($subscribers)->send(new NewsMail($request->validated()));
        return response()->json(['message' => 'email sent successfully'], 200);
    }

    public function show(Subscribe $subscribe)
    {
    }

    public function edit(Subscribe $subscribe)
    {
    }

    public function update(Request $request, Subscribe $subscribe)
    {
    }

    public function destroy(Subscribe $subscribe)
    {
    }
}
