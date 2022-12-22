<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $categories = Category::withCount('collections', 'nfts')->orderBy('id', 'desc')->get();
            return response()->json(CategoryResource::collection($categories));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $category = Category::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]);
            if ($request->hasFile('icon')) {
                $category->addMedia($request->icon)->toMediaCollection('category_icon');
            }
            return response()->json(CategoryResource::make($category));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function show(Category $category): JsonResponse
    {
        try {
            return response()->json(['data' => $category, 'icon' => $category->getFirstMedia('category_icon')->getUrl()]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(Category $category, Request $request): JsonResponse
    {
        try {
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
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


}
