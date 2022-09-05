<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        $products =  Product::paginate(20);
        return response()->json(ProductResource::collection($products));
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json(ProductResource::make($product));
    }

    public function show(Product $product)
    {
        return response()->json(ProductResource::make($product));
    }

    public function update(Product $product, Request $request)
    {
        $product->update($request->all());
        return response()->json(ProductResource::make($product));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
