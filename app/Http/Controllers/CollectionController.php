<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionCollaboratorRequest;
use App\Http\Requests\CollectionRequest;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\CollectionCollaborator;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CollectionController extends Controller
{
    public function index(): JsonResponse
    {
        $collections = Collection::with('category', 'nfts', 'collaborators', 'user')->paginate(20);
        return response()->json(CollectionResource::collection($collections));
    }

    public function store(CollectionRequest $request): JsonResponse
    {
        $collection = Collection::create($request->validated());
        CollectionCollaborator::create(['collection_id' => $collection->id, 'user_id' => auth()->id()]);
        return response()->json(['data' => CollectionResource::make($collection->load('category', 'nfts', 'user')), 'message' => 'collection created successfully'], 200);
    }


    public function show(Collection $collection): JsonResponse
    {
        return response()->json(CollectionResource::make($collection->load('category', 'nfts', 'user')));
    }


    public function update(Collection $collection, CollectionRequest $request): JsonResponse
    {
        $collection->update($request->validated());
        return response()->json(['data' => CollectionResource::make($collection->load('category', 'nfts', 'user')), 'message' => 'collection updated successfully'], 200);
    }

    public function destroy(Collection $collection): Response
    {
        $collection->delete();
        return response()->noContent();
    }

    public function report(Collection $collection, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $collection->reports()->create($data);
    }

    public function addCollaboration(Collection $collection, CollectionCollaboratorRequest $request)
    {
        try {
            $user = User::where('wallet_address', $request->wallet_address)->first();
            if (!$user)
                return response()->json(['message' => 'user with " ' . $request->wallet_address . ' " wallet address can\'t be found, please check it and try again'], 400);

            $collaboration_exist = CollectionCollaborator::where('user_id', $user->id)->where('collection_id', $collection->id)->first();
            if ($collaboration_exist)
                return response()->json(['message' => 'this user already collaborated with this collection'], 403);

            $collection->collaborators()->attach($user->id);
            return response()->json(['data' => ['collection' => CollectionResource::make($collection), 'collaborator' => $user], 'message' => 'collection collaboration created successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }

    }


    public function myCollections()
    {
        $user = auth()->user()->load(['collections', 'user']);
        return CollectionResource::collection($user['collections']);
    }

}
