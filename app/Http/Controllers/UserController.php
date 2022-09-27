<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\FollowableResource;
use App\Http\Resources\LikedNftsResource;
use App\Http\Resources\NftResource;
use App\Http\Resources\UserResource;
use App\Models\Collection;
use App\Models\Nft;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('collections', 'followers', 'followings', 'likes.likeable', 'followables.follower')->isEnabled()->paginate(10);
        return response()->json([
            'data' => UserResource::collection($users),
            'meta' => PaginationMeta::getPaginationMeta($users)
        ]);
    }

    public function show(User $user)
    {
        return response()->json(UserResource::make($user));
    }

    public function userCollections(User $user): JsonResponse
    {

        $collections = Collection::with('category', 'nfts', 'collaborators', 'user')->where('user_id', $user['id'])->paginate(10);
        return response()->json([
            'data' => CollectionResource::collection($collections),
            'meta' => PaginationMeta::getPaginationMeta($collections)
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
            $liked_nfts = $user->likes()->withType(Nft::class)->with('likeable.user', 'likeable.collection')->paginate(10);
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
            $followers = $user->followers()->with('followable')->paginate(10);
            return response()->json([
                'data' => FollowableResource::collection($followers),
                'meta' => PaginationMeta::getPaginationMeta($followers)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function report(User $user, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $user->reports()->create($data);
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
}
