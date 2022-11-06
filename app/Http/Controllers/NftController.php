<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\NftRequest;
use App\Http\Resources\NftResource;
use App\Models\Nft;
use App\Models\Transaction;
use App\Notifications\FollowerCreateNewNft;
use App\Notifications\UserBuyNftNotification;
use App\Notifications\UserSetNftForSaleNotification;
use App\Notifications\UserUpdateNftPriceNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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

    public function latest(): JsonResponse
    {
        $nfts = Nft::withFilters()->isPublished()->orderBy('created_at', 'desc')->paginate(15);
        return response()->json([
            'data' => NftResource::collection($nfts),
            'meta' => PaginationMeta::getPaginationMeta($nfts)
        ]);
    }

    public function show(Nft $nft): JsonResponse
    {
        return response()->json(NftResource::make($nft->load(['creator', 'owner', 'collection', 'watchers'])));
    }

    public function store(NftRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['creator_id'] = auth()->id();
            $data['owner_id'] = auth()->id();
            $nft = Nft::create($data);
            Transaction::query()->create([
                'nft_id' => $nft->id,
                'from' => auth()->id(),
                'to' => auth()->id(),
                'price' => $nft->price,
                'type' => 'mint'
            ]);
            Notification::send(auth()->user()->followers()->get(), new FollowerCreateNewNft($nft, auth()->user()));
            DB::commit();
            return response()->json(['nft' => NftResource::make($nft), 'message' => __('nft_created_successfully')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }

    }

    public function buyNft(Nft $nft): JsonResponse
    {

        if ($nft->owner_id == auth()->id()) {
            return response()->json(['message' => __('you_are_trying_to_buy_your_own_nft')], 403);
        }

        DB::beginTransaction();
        try {
            Transaction::query()->create([
                'nft_id' => $nft->id,
                'from' => $nft->owner_id,
                'to' => auth()->id(),
                'price' => $nft->price,
                'type' => 'sale'
            ]);
            $nft->update(['owner_id' => auth()->id()]);
            Notification::send(auth()->user()->followers()->get(), new UserBuyNftNotification($nft, auth()->user()));
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
            return response()->json(['message' => __('you_do_not_have_permission_to_maintain_on_this_NFT')], 403);

        $validator = Validator::make($request->all(), [
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $nft->update(['price' => $request->price]);
            Transaction::query()->create([
                'nft_id' => $nft->id,
                'from' => $nft->owner_id,
                'to' => auth()->id(),
                'price' => $nft->price,
                'type' => 'update_price'
            ]);
            Notification::send(auth()->user()->followers()->get(), new UserUpdateNftPriceNotification($nft, auth()->user()));
            DB::commit();
            return response()->json(['message' => __('nft_updated_successfully')], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }


    }


    public function toggleForSale(Nft $nft, Request $request)
    {
        if ($nft->owner_id != auth()->id())
            return response()->json(['message' => __('you_do_not_have_permission_to_maintain_on_this_NFT')], 403);


        try {
            DB::beginTransaction();
            $nft->is_for_sale = !$nft->is_for_sale;
            $nft->save();
            Transaction::query()->create([
                'nft_id' => $nft->id,
                'from' => $nft->owner_id,
                'to' => auth()->id(),
                'price' => $nft->price,
                'type' => 'set_for_sale'
            ]);
            Notification::send(auth()->user()->followers()->get(), new UserSetNftForSaleNotification($nft, auth()->user()));
            DB::commit();
            return response()->json(['message' => __('nft_listed_successfully')], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function changeNFTStatus(Nft $nft, Request $request)
    {
        try {
            $nft->status == 'published' ? $nft->status = 'hidden' : $nft->status = 'published';
            $nft->save();
            return response()->json(['message' => 'nft has been ' . $nft->status . ' successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }

    }


    public function destroy(Nft $nft)
    {
        if ($nft->owner_id != auth()->id())
            return response()->json(['message' => __('you_do_not_have_permission_to_maintain_on_this_NFT')], 403);
        $nft->delete();
        return response()->noContent();
    }


    public function toggleLike(Nft $nft)
    {
        $user = auth()->user();
        if ($user->hasLiked($nft)) {
            $user->unlike($nft);
            return response()->json(['message' => __('nft_unliked_successfully')], 200);
        } else {
            $user->like($nft);
            return response()->json(['message' => __('nft_liked_successfully')], 200);
        }
    }
}
