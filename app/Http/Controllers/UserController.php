<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\FollowableResource;
use App\Http\Resources\LikedNftsResource;
use App\Http\Resources\NftResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Models\Collection;
use App\Models\Nft;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    public function index()
    {
        $users = User::withFilters();
        return response()->json([
            'data' => UserResource::collection($users),
            'meta' => PaginationMeta::getPaginationMeta($users)
        ]);
    }

    public function show(User $user)
    {
        return response()->json(UserResource::make($user->load('subscribe', 'socialLinks', 'kyc', 'reports')->loadCount('owned_nfts', 'created_nfts', 'followers', 'followings', 'collections')));
    }

    public function userCollections(User $user): JsonResponse
    {

        $collections = Collection::with('category', 'nfts', 'collaborators', 'user')->where('user_id', $user['id'])->paginate(10);
        return response()->json([
            'data' => CollectionResource::collection($collections),
            'meta' => PaginationMeta::getPaginationMeta($collections)
        ]);
    }

    public function userTransactions(User $user): JsonResponse
    {

        $transactions = Transaction::with('to', 'nft')->where('from', $user['id'])->paginate(10);
        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'meta' => PaginationMeta::getPaginationMeta($transactions)
        ]);
    }


    public function ownedNfts(User $user): JsonResponse
    {
        $nfts = Nft::with('collection', 'owner', 'creator')->where('owner_id', $user['id'])->paginate(10);
        return response()->json([
            'data' => NftResource::collection($nfts),
            'meta' => PaginationMeta::getPaginationMeta($nfts)
        ]);
    }

    public function createdNfts(User $user): JsonResponse
    {
        $nfts = Nft::with('collection', 'owner', 'creator')->where('creator_id', $user['id'])->paginate(10);
        return response()->json([
            'data' => NftResource::collection($nfts),
            'meta' => PaginationMeta::getPaginationMeta($nfts)
        ]);
    }

    public function likedNfts(User $user): JsonResponse
    {
        try {
            $liked_nfts = $user->likes()->withType(Nft::class)->with('likeable.creator', 'likeable.owner', 'likeable.collection')->paginate(10);
            return response()->json([
                'data' => LikedNftsResource::collection($liked_nfts),
                'meta' => PaginationMeta::getPaginationMeta($liked_nfts)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function following(User $user): JsonResponse
    {
        try {
            $followings = $user->followings()->withType(User::class)->with('followable')->paginate(10);
            return response()->json([
                'data' => FollowableResource::collection($followings),
                'meta' => PaginationMeta::getPaginationMeta($followings)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function followers(User $user): JsonResponse
    {
        try {
            $followers = $user->followers()->paginate(10);
            return response()->json([
                'data' => UserResource::collection($followers),
                'meta' => PaginationMeta::getPaginationMeta($followers)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function toggleFollow(User $user)
    {
        $current_user = auth()->user();
        if ($current_user->isFollowing($user)) {
            $current_user->unfollow($user);
            return response()->json(['message' => 'author unfollowed successfully'], 200);
        } else {
            $current_user->follow($user);
            $user->acceptFollowRequestFrom($current_user);
            return response()->json(['message' => 'author followed successfully'], 200);
        }
    }


    public function toggleStatus(User $user)
    {
        if ($user->status == 'enabled') {
            $user->status = 'suspended';
            $user->save();
            return response()->json(['message' => 'user suspended successfully'], 200);
        } else {
            $user->status = 'enabled';
            $user->save();
            return response()->json(['message' => 'user activated successfully'], 200);
        }
    }


    public function verifyAccount(User $user)
    {
        try {
            $user->is_verified = true;
            $user->save();
            return response()->json(['message' => 'user verified successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }


    }
}
