<?php

namespace App\Http\Controllers;


use App\Helpers\CloudDPL;
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
        try {
            $nfts = Nft::withFilters()->paginate(10);

            return response()->json([
                'data' => NftResource::collection($nfts),
                'meta' => PaginationMeta::getPaginationMeta($nfts)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function latest(): JsonResponse
    {
        try {
            $nfts = Nft::withFilters()->isPublished()->orderBy('created_at', 'desc')->paginate(10);
            return response()->json([
                'data' => NftResource::collection($nfts),
                'meta' => PaginationMeta::getPaginationMeta($nfts)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Nft $nft): JsonResponse
    {
        try {
            return response()->json(NftResource::make($nft->load(['creator', 'owner', 'collection', 'watchers'])));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(NftRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['creator_id'] = auth()->id();
            $data['owner_id'] = auth()->id();
            $nft = Nft::create($data);

            Transaction::query()->create([
                'nft_id' => $nft->id,
                'from' => auth()->id(),
                'to' => auth()->id(),
                'price' => $nft->price,
                'tx_hash' => $request->tx_hash,
                'type' => 'mint'
            ]);
            Notification::sendNow(auth()->user()->followers()->get(), new FollowerCreateNewNft($nft, auth()->user()));
            DB::commit();
            return response()->json(['nft' => NftResource::make($nft), 'message' => __('nft_created_successfully')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function buyNft(Nft $nft, Request $request): JsonResponse
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
                'type' => 'sale',
                'tx_hash' => $request->tx_hash
            ]);
            $nft->update(['owner_id' => auth()->id()]);
            Notification::sendNow(auth()->user()->followers()->get(), new UserBuyNftNotification($nft, auth()->user()));
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
                'type' => 'update_price',
                'tx_hash' => $request->tx_hash
            ]);
            Notification::sendNow(auth()->user()->followers()->get(), new UserUpdateNftPriceNotification($nft, auth()->user()));
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


        DB::beginTransaction();
        try {
            $nft->is_for_sale = !$nft->is_for_sale;
            Transaction::query()->create([
                'nft_id' => $nft->id,
                'from' => $nft->owner_id,
                'to' => auth()->id(),
                'price' => $nft->price,
                'type' => $nft->is_for_sale ? 'cancel_sale' : 'set_for_sale',
                'tx_hash' => $request->tx_hash
            ]);
            $nft->save();
            Notification::sendNow(auth()->user()->followers()->get(), new UserSetNftForSaleNotification($nft, auth()->user()));
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


    public function destroy(Nft $nft, Request $request)
    {
        if ($nft->owner_id != auth()->id())
            return response()->json(['message' => __('you_do_not_have_permission_to_maintain_on_this_NFT')], 403);

        try {
            $nft->delete();
            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }

    }


    public function toggleLike(Nft $nft)
    {
        try {
            $user = auth()->user();
            if ($user->hasLiked($nft)) {
                $user->unlike($nft);
                return response()->json(['message' => __('nft_unliked_successfully')], 200);
            } else {
                $user->like($nft);
                return response()->json(['message' => __('nft_liked_successfully')], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }
}
