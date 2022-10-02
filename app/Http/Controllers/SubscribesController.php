<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Resources\SubscribeResource;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribesController extends Controller
{
    public function index()
    {
        $subscribed = Subscribe::query()->with('subscriber')->paginate(20);
        return response()->json([
            'subscribed' => SubscribeResource::collection($subscribed),
            'meta' => PaginationMeta::getPaginationMeta($subscribed)]);
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

    public function create()
    {
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
