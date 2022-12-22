<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use Exception;
use Illuminate\Http\Request;


class WatchController extends Controller
{
    public function store(Request $request)
    {
        try {
            $already_watched = Watch::query()->where('nft_id', '=', $request->nft_id)->where('user_id', '=', auth()->id())->exists();
            if (!$already_watched)
                Watch::query()->create([
                    'nft_id' => $request->nft_id,
                    'user_id' => auth()->id()
                ]);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
