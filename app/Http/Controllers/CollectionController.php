<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\CollectionCollaborator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CollectionController extends Controller
{
    public function index(): JsonResponse
    {
        $collections = Collection::with('category')->paginate(20);
        return response()->json(CollectionResource::collection($collections));
    }

    public function store(CollectionRequest $request): JsonResponse
    {
        $collection = Collection::create($request->validated());
        CollectionCollaborator::create(['collection_id' => $collection->id, 'user_id' => auth()->id()]);
        return response()->json(['data' => CollectionResource::make($collection), 'message' => 'collection created successfully'], 200);
    }


    public function show(Collection $collection): JsonResponse
    {
        return response()->json(CollectionResource::make($collection->load('category')));
    }


    public function update(Collection $collection, CollectionRequest $request): JsonResponse
    {
        $collection->update($request->validated());
        return response()->json(['data' => CollectionResource::make($collection), 'message' => 'collection updated successfully'], 200);
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

}
