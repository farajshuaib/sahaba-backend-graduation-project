<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use Illuminate\Http\Request;


class WatchController extends Controller
{
    

    public function store(Request $request)
    {
        $already_watched = Watch::query()->where('nft_id', '=', $request->nft_id)->where('user_id', '=', auth()->id())->exists();

        if (!$already_watched)
            Watch::query()->create([
                'nft_id' => $request->nft_id,
                'user_id' => auth()->id()
            ]);

        return response()->noContent();
    }
}
