<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $collections =  Category::query()->paginate(20);
        return response()->json(CategoryResource::collection($collections));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $collection = Category::create($request->all());
        return response()->json(CategoryResource::make($collection));
    }


    public function show(Category $category): \Illuminate\Http\JsonResponse
    {
        return response()->json(CategoryResource::make($category));
    }


    public function update(Category $category, Request $request): \Illuminate\Http\JsonResponse
    {
        $category->update($request->all());
        return response()->json(CategoryResource::make($category));
    }

    public function destroy(Category $category): \Illuminate\Http\Response
    {
        $category->delete();
        return response()->noContent();
    }

}
