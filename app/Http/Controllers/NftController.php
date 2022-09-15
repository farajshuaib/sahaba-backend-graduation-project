<?php

namespace App\Http\Controllers;

use App\Http\Resources\NftResource;
use App\Models\Nft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NftController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $nfts =  Nft::with('category', 'collection')
            ->withCount('transfers')
            ->isApproved()
            ->paginate(20);
        return response()->json(NftResource::collection($nfts));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $nft = Nft::create($request->all());
        return response()->json(NftResource::make($nft));
    }

    public function show(Nft $nft): \Illuminate\Http\JsonResponse
    {
        return response()->json(NftResource::make($nft));
    }

    public function update(Nft $nft, Request $request)
    {
        $nft->update($request->all());
        return response()->json(NftResource::make($nft));
    }

    public function destroy(Nft $nft)
    {
        $nft->delete();
        return response()->noContent();
    }


    public function likedByUser(){
        // find only nft where user liked them
        return response()->json(['data' => Nft::whereLikedBy(auth()->id)->with('likeCounter')->get()]);
    }

    public function toggleLike(Nft $nft){
        if($nft->liked()){
            $nft->unlike();
            return response()->json(['message' => 'nft unliked successfully'],200);
        } else {
            $nft->like();
            return response()->json(['message' => 'nft liked successfully'],200);
        }
    }


}
