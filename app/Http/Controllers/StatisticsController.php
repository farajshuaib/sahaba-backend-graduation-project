<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Kyc;
use App\Models\Nft;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;


class StatisticsController extends Controller
{
    public function general()
    {
        return response()->json([
            'nfts' => Nft::count(),
            'users' => User::count(),
            'transactions' => Transaction::count(),
            'sales' => Transaction::where('type', 'sale')->count(),
            'purchases' => Transaction::where('type', 'purchase')->count(),
            'total_sales' => Transaction::where('type', 'sale')->sum('amount'),
            'total_purchases' => Transaction::where('type', 'purchase')->sum('amount'),
        ]);
    }


    public function categoriesNfts(): JsonResponse
    {
        $categoriesCount = Category::query()->withCount('nfts')->get();
        return response()->json([
            'data' => [
                'labels' => $categoriesCount->pluck('name_en'),
                'data' => $categoriesCount->pluck('nfts_count')
            ]
        ], 200);
    }

    public function transactions(): JsonResponse
    {
        try {
            $mintStatistics = Transaction::query()
                ->whereMonth('created_at', '>=', Carbon::now()->subMonth()->month)
                ->where('type', 'mint')
                ->groupBy('label')
                ->selectRaw('count(*) as count, DATE(created_at) as label')
                ->get();


            $saleStatistics = Transaction::query()
                ->whereMonth('created_at', '>=', Carbon::now()->subMonth()->month)
                ->where('type', 'sale')
                ->groupBy('label')
                ->selectRaw('count(*) as count, DATE(created_at) as label')
                ->get();

            $labels = [];
            $labels = array_merge($labels, $mintStatistics->pluck('label')->toArray(), $saleStatistics->pluck('label')->toArray());


            return response()->json([
                'data' => [
                    'count' => [
                        'total_sold_tokens' => Transaction::query()->where('type', 'sale')->count(),
                        'total_sold_amount' => Transaction::query()->where('type', 'sale')->sum('price'),
                    ],
                    'statistics' => [
                        'labels' => array_unique($labels),
                        'mint' => $mintStatistics->pluck('count', 'label'),
                        'sale' => $saleStatistics->pluck('count', 'label')
                    ]
                ],

            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'something went wrong', 'error' => $e], 500);
        }
    }

    public function kyc()
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
