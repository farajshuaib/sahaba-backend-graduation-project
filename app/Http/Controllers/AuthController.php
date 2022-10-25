<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPasswordMail;
use App\Models\Admin;
use App\Models\Subscribe;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;

class AuthController extends Controller
{
    public function connectWallet(Request $request): JsonResponse
    {
        $user = User::where('wallet_address', $request->wallet_address)->first();

        if (!$user) {
            $user = User::create([
                'wallet_address' => $request->wallet_address,
            ]);
            $user->assignRole('author');
        }

        $user->fcm_token = $request->fcm_token;
        $user->save();

        $token = $user->createToken('API Token: ' . $request->header('User-Agent'))->plainTextToken;


        return response()->json([
            'token' => $token,
            'user' => UserResource::make($user->load('subscribe', 'socialLinks', 'subscribe', 'kyc'))
        ], 200);

    }

    public function adminLogin(Request $request): JsonResponse
    {
        $user = Admin::query()->where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('API Token: ' . $request->header('User-Agent'))->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
            return response()->json(['message' => 'invalid password'], 403);
        }
        return response()->json(['message' => 'email not exist'], 404);
    }


    public function createAdmin(CreateAdminRequest $request): JsonResponse
    {
        $admin = Admin::query()->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $admin->assignRole('admin');
        $admin->save();

        $token = $admin->createToken('API Token: ' . $request->header('User-Agent'))->plainTextToken;


        return response()->json([
            'token' => $token,
            'user' => $admin
        ], 200);

    }

    public function IsLoggedIn(): JsonResponse
    {
        if (auth()->check()) {
            return response()->json(['message' => 'success', 'user' => auth()->user()]);
        }
        return response()->json(['message' => 'failed'], 401);
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
        DB::beginTransaction();
        try {
            $user = auth()->user();
            if (!$user)
                return response()->json(['message' => 'you are not allowed to modify account'], 403);

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'bio' => $request->bio,
            ]);

            if ($request->email) {
                Subscribe::query()->updateOrCreate([
                    'user_id' => auth()->id(),
                    'email' => $request->email
                ]);
            }

            $socialLinks = $request->only(['facebook_url', 'twitter_url', 'telegram_url', 'website_url']);
            $user->socialLinks()->updateOrCreate($socialLinks);

            if ($request->hasFile('profile_photo')) {
                $user->addMedia($request->profile_photo)->toMediaCollection('users_profile');
            }

            if ($request->hasFile('banner_photo')) {
                $user->addMedia($request->banner_photo)->toMediaCollection('users_banner');
            }

            DB::commit();
            return response()->json([
                'user' => UserResource::make($user->load('subscribe', 'socialLinks', 'subscribe', 'kyc')),
                'message' => 'update success'
            ],
                200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function sendResetLink(SendResetLinkRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'), function ($notifiable, $token) {
            Mail::to($notifiable->email)->send(new ForgotPasswordMail($token, $notifiable->email));
        });

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'link sent to your email successfully'], 200);
        }

        return response()->json(['error' => trans($status)], 400);
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->noContent(200);
        }
        return response()->json(['error' => $status], 400);
    }

}
