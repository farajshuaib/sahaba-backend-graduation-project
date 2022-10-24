<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::withFilters()->paginate(5);
        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'meta' => PaginationMeta::getPaginationMeta($transactions)
        ], 200);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        try {
            return response()->json(TransactionResource::make($transaction->load(['fromUser', 'toUser', 'nft'])), 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'transaction not found'], 404);
        }
    }

    public function statistics(): JsonResponse
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

}
