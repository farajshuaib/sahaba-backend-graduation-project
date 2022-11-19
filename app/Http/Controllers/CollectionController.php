<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\CollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\CollectionCollaborator;
use App\Notifications\FollowerCreateNewCollectionNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


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
                'id' => $request->id,
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'is_sensitive_content' => (bool)$request->is_sensitive_content,
                'category_id' => $request->category_id,
                'blockchain_id' => $request->blockchain_id,
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
            Notification::sendNow(auth()->user()->followers()->get(), new FollowerCreateNewCollectionNotification($collection, auth()->user()));
            DB::commit();
            return response()->json(['data' => CollectionResource::make($collection->load('category', 'socialLinks', 'user')), 'message' => __('collection_created_successfully')], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function show(Collection $collection): JsonResponse
    {
        return response()->json(CollectionResource::make($collection->load(['category', 'user', 'socialLinks', 'reports.user', 'collaborators.user'])));
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
            return response()->json(['data' => CollectionResource::make($collection->load('socialLinks')), 'message' => __('collection_updated_successfully')], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e, 'message' => __('collection_updated_failed')], 500);
        }

    }


    public function myCollections()
    {
        $user = auth()->user()->load(['collections']);
        return CollectionResource::collection($user['collections']);
    }

}
