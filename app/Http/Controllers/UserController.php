<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::role('user')->paginate(10);
        return response()->json(UserResource::collection($users));
    }

    public function show(User $user)
    {
        return response()->json(UserResource::make($user));
    }

    public function report(User $user, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $user->reports()->create($data);
    }
}
