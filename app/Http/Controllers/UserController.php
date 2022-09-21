<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\NftResource;
use App\Http\Resources\UserResource;
use App\Models\Collection;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('collections', 'followers', 'followings', 'likes.likeable')->isEnabled()->paginate(10);
        return response()->json([
            'data' => UserResource::collection($users),
            'meta' => PaginationMeta::getPaginationMeta($users)
        ]);
    }

    public function show(User $user)
    {
        if ($user->status != 'enabled')
            return response()->json(['message' => 'user is suspended, profile can not be accessedÏ']);
        return response()->json(UserResource::make($user->load('collections', 'followers', 'followings', 'likes.likeable')));
    }

    public function userCollections(User $user): JsonResponse
    {
        $collections = Collection::with('category', 'nfts', 'collaborators', 'user')->where('user_id', $user['id'])->paginate(10);
        return response()->json([
            'data' => CollectionResource::collection($collections),
            'meta' => PaginationMeta::getPaginationMeta($collections)
        ]);
    }


    public function userNfts(User $user): JsonResponse
    {
        $nfts = Nft::with('collection')->where('user_id', $user['id'])->paginate(10);
        return response()->json([
            'data' => NftResource::collection($nfts),
            'meta' => PaginationMeta::getPaginationMeta($nfts)
        ]);
    }

    public function likedNfts(User $user): JsonResponse
    {
        try {
            $nfts = $user->likes()->withType(Nft::class)->with('likeable')->paginate(10);
            return response()->json(['data' => NftResource::collection($nfts), 'meta' => PaginationMeta::getPaginationMeta($nfts)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function following(User $user): JsonResponse
    {
        try {
            $users = $user->followings()->paginate(10);
            return response()->json([
                'data' => UserResource::collection($users),
                'meta' => PaginationMeta::getPaginationMeta($users)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function followers(User $user): JsonResponse
    {
        try {
            $users = $user->followers()->paginate(10);
            return response()->json([
                'data' => UserResource::collection($users),
                'meta' => PaginationMeta::getPaginationMeta($users)
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
}
