<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\Nft;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $collections =  Collection::paginate(20);
        return response()->json(CollectionResource::collection($collections));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $collection = Collection::create($request->all());
        return response()->json(CollectionResource::make($collection));
    }


    public function show(Collection $collection): \Illuminate\Http\JsonResponse
    {
        return response()->json(CollectionResource::make($collection));
    }


    public function update(Collection $collection, Request $request): \Illuminate\Http\JsonResponse
    {
        $collection->update($request->all());
        return response()->json(CollectionResource::make($collection));
    }

    public function destroy(Collection $collection): \Illuminate\Http\Response
    {
        $collection->delete();
        return response()->noContent();
    }


}
