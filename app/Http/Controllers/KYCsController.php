<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\Kyc_Request;
use App\Http\Resources\UserResource;
use App\Models\Kyc;
use App\Models\User;
use Illuminate\Http\Request;

class KYCsController extends Controller
{
    public function index()
    {
        $users = User::with('kyc')->whereHas('kyc')->paginate(20);
        return response()->json([
            'data' => UserResource::collection($users),
            'meta' => PaginationMeta::getPaginationMeta($users)
        ]);
    }

    public function store(Kyc_Request $request)
    {
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
    }

    public function show(Kyc $KYC)
    {
    }

    public function changeAccountStatus(Kyc $kyc, Request $request)
    {
        $statuses = ['on_review', 'approved', 'rejected', 'pending'];
        if (in_array($request->status, $statuses)) {
            $kyc->status = $request->status;
            $kyc->save();
            return response()->json([
                'message' => 'account status updated successfully',
                'user' => UserResource::make(User::query()->with('kyc')->find($kyc->user_id))]);

        }
        return response()->json(['message' => 'invalid status'], 422);
    }

    public function update(Kyc $kys, Request $request)
    {
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
    }
}
