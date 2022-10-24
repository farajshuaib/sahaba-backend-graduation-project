<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\Kyc_Request;
use App\Http\Resources\UserResource;
use App\Models\Kyc;
use App\Models\User;
use Carbon\Carbon;
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

    public function statistics()
    {
        $onReviewStatistics = Kyc::query()
            ->whereMonth('created_at', '>=', Carbon::now()->subMonth()->month)
            ->where('status', 'on_review')
            ->groupBy('label')
            ->selectRaw('count(*) as count, DATE(created_at) as label')
            ->get();

        $approvedStatistics = Kyc::query()
            ->whereMonth('created_at', '>=', Carbon::now()->subMonth()->month)
            ->where('status', 'approved')
            ->groupBy('label')
            ->selectRaw('count(*) as count, DATE(created_at) as label')
            ->get();

        $rejectedStatistics = Kyc::query()
            ->whereMonth('created_at', '>=', Carbon::now()->subMonth()->month)
            ->where('status', 'rejected')
            ->groupBy('label')
            ->selectRaw('count(*) as count, DATE(created_at) as label')
            ->get();

        $pendingStatistics = Kyc::query()
            ->whereMonth('created_at', '>=', Carbon::now()->subMonth()->month)
            ->where('status', 'pending')
            ->groupBy('label')
            ->selectRaw('count(*) as count, DATE(created_at) as label')
            ->get();


        $labels = [];
        $labels = array_merge($labels, $onReviewStatistics->pluck('label')->toArray(), $approvedStatistics->pluck('label')->toArray(), $rejectedStatistics->pluck('label')->toArray(), $pendingStatistics->pluck('label')->toArray());

        return response()->json([
            'data' => [
                'count' => [
                    'total' => Kyc::query()->count(),
                    'on_review' => Kyc::query()->where('status', 'on_review')->count(),
                    'approved' => Kyc::query()->where('status', 'approved')->count(),
                    'rejected' => Kyc::query()->where('status', 'rejected')->count(),
                    'pending' => Kyc::query()->where('status', 'pending')->count(),
                ],
                'statistics' => [
                    'labels' => array_unique($labels),
                    'on_review' => $onReviewStatistics->pluck('count', 'label'),
                    'approved' => $approvedStatistics->pluck('count', 'label'),
                    'rejected' => $rejectedStatistics->pluck('count', 'label'),
                    'pending' => $pendingStatistics->pluck('count', 'label'),
                ]

            ]
        ], 200);
    }
}
