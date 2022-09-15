<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Nft;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function connectWallet(Request $request): \Illuminate\Http\JsonResponse
    {
        if(auth()->user())
            return response()->json(['user' => auth()->user()]);


            $user = User::where('wallet_address', $request->wallet_address)->first();

            if(!$user) {
                $user = User::create([
                    'wallet_address' => $request->wallet_address
                ]);
                $user->assignRole(2);
            }
            $token = $user->createToken('API Token: ' . $request->header('User-Agent'))->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);

    }

    public function logout(): \Illuminate\Http\Response
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        $user->save();
        return response()->noContent(204);
    }

    /**
     * @throws \Throwable
     */
    public function update(User $user, Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user->update([
                'username' => $request->username,
                'email' => $request->email,
                'bio' => $request->bio,
                'profile_photo' => $request->profile_photo,
                'website_url' => $request->website_url,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'telegram_url' => $request->telegram_url,
            ]);
            return response()->json(UserResource::make($user),200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()],500);
        }


    }


    public  function  show(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user
        ]);
    }
}
