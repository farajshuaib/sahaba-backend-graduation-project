<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\CollectionCollaboratorRequest;
use App\Http\Requests\CollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\CollectionCollaborator;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function index(): JsonResponse
    {
        $collections = Collection::withFilters();
        return response()->json([
            'data' => CollectionResource::collection($collections),
            'meta' => PaginationMeta::getPaginationMeta($collections)
        ]);
    }

    public function store(CollectionRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $collection = Collection::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'is_sensitive_content' => $request->is_sensitive_content == 'true',
                'collection_token_id' => $request->collection_token_id,
                'category_id' => $request->category_id,
            ]);
            $socialLinks = $request->only(['facebook_url', 'twitter_url', 'telegram_url', 'website_url']);
            $collection->socialLinks()->updateOrCreate($socialLinks);

            if ($request->hasFile('logo_image')) {
                $collection->addMedia($request->logo_image)->toMediaCollection('collection_logo_image');
            }
            if ($request->hasFile('banner_image')) {
                $collection->addMedia($request->banner_image)->toMediaCollection('collection_banner_image');
            }
            CollectionCollaborator::create(['collection_id' => $collection->id, 'user_id' => auth()->id()]);
            DB::commit();
            return response()->json(['data' => CollectionResource::make($collection->load('category', 'socialLinks', 'nfts', 'user')), 'message' => 'collection created successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e]);
        }
    }


    public function show(Collection $collection): JsonResponse
    {
        return response()->json(CollectionResource::make($collection->load(['category', 'user', 'socialLinks'])));
    }


    public function update(Collection $collection, UpdateCollectionRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $collection->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_sensitive_content' => $request->is_sensitive_content == 'true',
                'category_id' => $request->category_id,
            ]);
            $socialLinks = $request->only(['facebook_url', 'twitter_url', 'telegram_url', 'website_url']);
            $collection->socialLinks()->updateOrCreate($socialLinks);
            if ($request->hasFile('logo_image')) {
                $collection->addMedia($request->logo_image)->toMediaCollection('collection_logo_image');
            }
            if ($request->hasFile('banner_image')) {
                $collection->addMedia($request->banner_image)->toMediaCollection('collection_banner_image');
            }
            DB::commit();
            return response()->json(['data' => CollectionResource::make($collection->load('socialLinks')), 'message' => 'collection updated successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e, 'message' => 'collection updated faild'], 500);
        }

    }


    public function addCollaboration(Collection $collection, CollectionCollaboratorRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($collection->user_id != auth()->id())
                return response()->json(['message' => 'you\'re not allowed to add collaboration to this collection'], 403);
            $user = User::where('wallet_address', $request->wallet_address)->first();
            if (!$user)
                return response()->json(['message' => 'user with " ' . $request->wallet_address . ' " wallet address can\'t be found, please check it and try again'], 400);

            $collaboration_exist = CollectionCollaborator::where('user_id', $user->id)->where('collection_id', $collection->id)->exists();
            if ($collaboration_exist)
                return response()->json(['message' => 'this user already collaborated with this collection'], 403);
            $collection->collaborators()->attach($user->id);
            DB::commit();
            return response()->json(['data' => ['collection' => CollectionResource::make($collection), 'collaborator' => $user], 'message' => 'collection collaboration created successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);

        }

    }


    public function myCollections()
    {
        $user = auth()->user()->load(['collections']);
        return CollectionResource::collection($user['collections']);
    }

}
