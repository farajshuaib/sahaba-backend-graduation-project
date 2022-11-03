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
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
        if ($request->hasFile('icon')) {
            $category->addMedia($request->icon)->toMediaCollection('category_icon');
        }
        return response()->json(CategoryResource::make($category));
    }


    public function show(Category $category): JsonResponse
    {
        return response()->json(['data' => $category, 'icon' => $category->getFirstMedia('category_icon')->getUrl()]);
    }


    public function update(Category $category, Request $request): JsonResponse
    {
        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
        if ($request->hasFile('icon')) {
            $category->addMedia($request->icon)->toMediaCollection('category_icon');
        }
        return response()->json([
            'category' => CategoryResource::make($category),
            'message' => 'update success'
        ],
            200);
    }


}
