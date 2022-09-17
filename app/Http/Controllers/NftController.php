<?php

namespace App\Http\Controllers;

use App\Http\Requests\NftRequest;
use App\Http\Resources\NftResource;
use App\Models\Nft;
use Exception;
use Illuminate\Http\JsonResponse;


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
            $nft->refresh();
            $nft->load('user.nfts');
            return response()->json(['nft' => NftResource::make($nft), 'message' => 'nft created successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }

    }

    public function show(Nft $nft): JsonResponse
    {
        $nft->load('user');
        return response()->json(NftResource::make($nft));
    }

    public function update(Nft $nft, NftRequest $request)
    {
        $nft->update($request->validated());
        return response()->json(NftResource::make($nft));
    }

    public function destroy(Nft $nft)
    {
        $nft->delete();
        return response()->noContent();
    }


    public function likedByUser()
    {
        // find only nft where user liked them
        return response()->json(['data' => Nft::whereLikedBy(auth()->id)->with('likeCounter')->get()]);
    }

    public function toggleLike(Nft $nft)
    {
        if ($nft->liked()) {
            $nft->unlike();
            return response()->json(['message' => 'nft unliked successfully'], 200);
        } else {
            $nft->like();
            return response()->json(['message' => 'nft liked successfully'], 200);
        }
    }


}
