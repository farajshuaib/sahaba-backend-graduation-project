<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(){
        $users = User::role('user')->paginate(10);
        return response()->json(UserResource::collection($users));
    }

    public function show(User $user){
        return response()->json(UserResource::make($user));
    }
}
