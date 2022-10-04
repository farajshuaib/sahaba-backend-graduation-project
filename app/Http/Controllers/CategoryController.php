<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {
        $categories = Category::with('collections')->orderBy('id', 'desc')->get();
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
        return response()->json(CategoryResource::make($category->load('collections', 'nfts')));
    }


    public function update(Category $category, Request $request): JsonResponse
    {
        $category->update(['name' => $request->name]);
        if ($request->hasFile('icon')) {
            $category->addMedia($request->icon)->toMediaCollection('category_icon');
        }
        return response()->json([
            'user' => CategoryResource::make($category->load('collections', 'nfts')),
            'message' => 'update success'
        ],
            200);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();
        return response()->noContent();
    }

}
