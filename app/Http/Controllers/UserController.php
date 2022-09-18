<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('collections', 'followers', 'followings', 'likes.likeable')->isEnabled()->paginate(10);
        return response()->json(UserResource::collection($users));
    }

    public function show(User $user)
    {
        if ($user->status != 'enabled')
            return response()->json(['message' => 'user is suspended, profile can not be accessedÏ']);
        return response()->json(UserResource::make($user->load('collections', 'followers', 'followings', 'likes.likeable')));
    }

    public function report(User $user, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $user->reports()->create($data);
    }
}
