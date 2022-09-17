<?php

namespace App\Http\Controllers;

use App\Http\Requests\NftRequest;
use App\Http\Resources\NftResource;
use App\Models\Nft;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class NftController extends Controller
{
    public function index(): JsonResponse
    {
        $nfts = Nft::with('user', 'collection')
            ->paginate(20);
        return response()->json(NftResource::collection($nfts));
    }

    public function store(NftRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $data['creator_address'] = auth()->user()->wallet_address;
            $nft = Nft::create($data);
            return response()->json(['nft' => NftResource::make($nft), 'message' => 'nft created successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }

    }

    public function show(Nft $nft): JsonResponse
    {
        return response()->json(NftResource::make($nft->load(['user', 'collection'])));
    }

    public function update(Nft $nft, NftRequest $request)
    {
        $nft->update($request->validated());
        return response()->json(['nft' => NftResource::make($nft), 'message' => 'nft updated successfully']);
    }

    public function destroy(Nft $nft)
    {
        $nft->delete();
        return response()->noContent();
    }


    public function likedByUser()
    {
        try {
            // find only nft where user liked them
            $nfts = auth()->user()->likes()->withType(Nft::class)->with('likeCounter')->paginate(20);
            return response()->json($nfts);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function toggleLike(Nft $nft)
    {
        $nft->liked()? $nft->unlike() : $nft->like();
        return response()->noContent();

//        if ($nft->liked()) {
//            $nft->unlike();
//            return response()->json(['message' => 'nft unliked successfully'], 200);
//        } else {
//            $nft->like();
//            return response()->json(['message' => 'nft liked successfully'], 200);
//        }
    }

    public function report(Nft $nft, Request $request)
    {
        $nft->reports()->create([
           'reporter_id' => auth()->id(),
           'reason' => $request->reason
        ]);
    }


}
