<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\Kyc_Request;
use App\Http\Resources\UserResource;
use App\Models\Kyc;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class KYCsController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('kyc')->whereHas('kyc')->paginate(20);
            return response()->json([
                'data' => UserResource::collection($users),
                'meta' => PaginationMeta::getPaginationMeta($users)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Kyc_Request $request)
    {
        try {
            $kys = Kyc::query()->create([
                'gender' => $request->gender,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'author_type' => $request->author_type,
                'author_art_type' => $request->author_art_type,
                'user_id' => auth()->id(),
            ]);
            if ($request->hasFile('passport_id')) {
                $kys->addMedia($request->passport_id)->toMediaCollection('passport_id');
            }
            return response()->json(UserResource::make(auth()->user()->load('kyc')));
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function changeAccountStatus(Kyc $kyc, Request $request)
    {
        try {
            $statuses = ['on_review', 'approved', 'rejected', 'pending'];
            if (in_array($request->status, $statuses)) {
                $kyc->status = $request->status;
                $kyc->save();
                return response()->json([
                    'message' => __('account_status_updated_successfully'),
                    'user' => UserResource::make(User::query()->with('kyc')->find($kyc->user_id))]);

            }
            return response()->json(['message' => 'invalid status'], 422);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(Kyc $kys, Request $request)
    {
        try {
            $kys = $kys->update([
                'gender' => $request->gender,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'author_type' => $request->author_type,
                'author_art_type' => $request->author_art_type,
                'user_id' => $request->user_id,
            ]);
            if ($request->hasFile('passport_id')) {
                $kys->addMedia($request->passport_id)->toMediaCollection('passport_id');
            }
            return response()->json(UserResource::make(User::query()->find($request->user_id)->load('kyc')));
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


}
