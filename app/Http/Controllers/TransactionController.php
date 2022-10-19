<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\JsonResponse;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::query()->with(['from', 'to', 'nft'])->paginate(20);
        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'meta' => PaginationMeta::getPaginationMeta($transactions)
        ], 200);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        try {
            return response()->json(TransactionResource::make($transaction->load(['from', 'to', 'nft'])), 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'transaction not found'], 404);
        }

    }

}
