<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\NftRequest;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\NftResource;
use App\Models\Nft;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class NftController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $nfts = Nft::withFilters()->paginate(15);
        return response()->json([
            'data' => NftResource::collection($nfts),
            'meta' => PaginationMeta::getPaginationMeta($nfts)
        ]);
    }

    public function latest()
    {
        if (auth()->check()) {
            $followings = auth()->user()->followings()->withType(User::class)->with('followable');
            $nfts = Nft::withFilters()->paginate(15);
        } else {
            $nfts = Nft::withFilters()->paginate(15);
        }
        return response()->json([
            'data' => NftResource::collection($nfts),
            'meta' => PaginationMeta::getPaginationMeta($nfts)
        ]);
    }

    public function show(Nft $nft): JsonResponse
    {
        return response()->json(NftResource::make($nft->load(['creator', 'owner', 'collection', 'transactions', 'watchers'])));
    }

    public function store(NftRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['creator_id'] = auth()->id();
            $data['owner_id'] = auth()->id();
            $nft = Nft::create($data);
            return response()->json(['nft' => NftResource::make($nft), 'message' => 'nft created successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }

    }

    public function buyNft(Nft $nft): JsonResponse
    {

        if ($nft->owner_id == auth()->id()) {
            return response()->json(['message' => 'what the fuck you\'re trying to do dude, it\'s your nft'], 403);
        }

        DB::beginTransaction();
        try {
            Transaction::create([
                'nft_id' => $nft->id,
                'from' => $nft->owner_id,
                'to' => auth()->id(),
                'price' => $nft->price,
            ]);
            $nft->update(['owner_id' => auth()->id()]);
            DB::commit();
            return response()->json(['nft' => NftResource::make($nft->load('collection', 'owner', 'creator')), 'message' => 'purchase successfully done'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }

    }

    public function updatePrice(Nft $nft, Request $request)
    {
        if ($nft->owner_id != auth()->id())
            return response()->json(['message' => 'you don\'t have permission to maintain on this NFT'], 403);

        $validator = Validator::make($request->all(), [
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 422);
        }


        $nft->update(['price' => $request->price]);
        return response()->json(['message' => 'nft updated successfully']);
    }


    public function setForSale(Nft $nft, Request $request)
    {
        if ($nft->owner_id != auth()->id())
            return response()->json(['message' => 'you don\'t have permission to maintain on this NFT'], 403);

        $validator = Validator::make($request->all(), [
            'sale_end_at' => ['required', 'date']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 422);
        }


        $nft->update(['is_for_sale' => true, 'sale_end_at' => $request->sale_end_at]);

        return response()->json(['message' => 'item listed successfully'], 200);
    }


    public function stopSale(Nft $nft)
    {
        if ($nft->owner_id != auth()->id())
            return response()->json(['message' => 'you don\'t have permission to maintain on this NFT'], 403);

        $nft->update(['is_for_sale' => false, 'sale_end_at' => null]);


        return response()->json(['message' => 'item canceled listed successfully'], 200);
    }


    public function destroy(Nft $nft)
    {
        $nft->delete();
        return response()->noContent();
    }


    public function toggleLike(Nft $nft)
    {
        $user = auth()->user();
        if ($user->hasLiked($nft)) {
            $user->unlike($nft);
            return response()->json(['message' => 'nft unliked successfully'], 200);
        } else {
            $user->like($nft);
            return response()->json(['message' => 'nft liked successfully'], 200);
        }
    }

    public function report(Nft $nft, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $nft->reports()->create($data);
    }


}
