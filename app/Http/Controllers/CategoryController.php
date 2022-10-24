<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {
        $categories = Category::withCount('collections', 'nfts')->orderBy('id', 'desc')->get();
//        dd($categories);
        return response()->json(CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $category = Category::create([
            'name' => $request->name
        ]);
        if ($request->hasFile('icon')) {
            $category->addMedia($request->icon)->toMediaCollection('category_icon');
        }
        return response()->json(CategoryResource::make($category));
    }


    public function show(Category $category): JsonResponse
    {
        return response()->json(CategoryResource::make($category->load('nfts')->loadCount('collections', 'nfts')));
    }


    public function update(Category $category, Request $request): JsonResponse
    {
        $category->update(['name' => $request->name]);
        if ($request->hasFile('icon')) {
            $category->addMedia($request->icon)->toMediaCollection('category_icon');
        }
        return response()->json([
            'category' => CategoryResource::make($category),
            'message' => 'update success'
        ],
            200);
    }

    public function statistics(): JsonResponse
    {
        $categoriesCount = Category::query()->withCount('nfts')->get();
        return response()->json([
            'data' => [
                'labels' => $categoriesCount->pluck('name'),
                'data' => $categoriesCount->pluck('nfts_count')
            ]
        ], 200);
    }

}
