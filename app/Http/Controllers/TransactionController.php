<?php

namespace App\Http\Controllers;

use App\Models\Transaction;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('from, to, nfts')->get();
        return response()->json($transactions);
    }

}
