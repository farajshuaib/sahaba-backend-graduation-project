<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;


class AuthController extends Controller
{
    public function connectWallet(Request $request): JsonResponse
    {
        $user = User::where('wallet_address', $request->wallet_address)->first();

        if (!$user) {
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

    public function logout(): Response
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        $user->save();
        return response()->noContent(204);
    }

    /**
     * @throws Throwable
     */
    public function update(UserRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            if (!$user) exit(403);
            $user->update($request->validated());
            return response()->json([
                'user' => UserResource::make($user),
                'message' => 'update success'
            ],
                200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }


    }

}
