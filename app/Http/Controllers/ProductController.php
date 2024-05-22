<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : object
    {
        $perPage = $request->query('page', 10);
        if (!is_numeric($perPage) || $perPage <= 0) {
            return response()->json(['message' => 'not found'], 404);
        }

        $products = Product::with('images', 'productType')->paginate($perPage);

        return response()->json($products);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $request->validated();
        $product = Product::create($request->all());

        return response()->json($product->latest()->first(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Product::with('images')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $productRequest, string $id)
    {
        $productRequest->validated();
        $product = Product::with('images')->find($id);
        $product->update($productRequest->all());

        return response()->json($product, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->images()->delete();
        $product->delete();

        return response()->json('deleted');
    }

}
