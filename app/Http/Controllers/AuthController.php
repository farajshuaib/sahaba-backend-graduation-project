<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function connectWallet(Request $request) {
        if(auth()->user())
            return response()->json(['user' => auth()->user()]);


            $user = User::where('wallet_address', $request->wallet_address)->first();

            if(!$user) {
                $user = User::create([
                    'wallet_address' => $request->wallet_address,
                    'role_id' => 2
                ]);
            }
            $token = $user->createToken('API Token: ' . $request->header('User-Agent'))->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);

    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        $user->save();
        return response()->noContent(204);
    }
}
