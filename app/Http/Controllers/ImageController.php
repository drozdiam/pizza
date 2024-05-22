<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageStoreRequest $imagesRequest, $productId)
    {
        $product = Product::with('images')->findOrFail($productId);
        $imagesRequest->validated();

        $imageFiles = $imagesRequest->file('img_src');

        $images = [];
        foreach ($imageFiles as $file) {
            $path = $file->store('images', 'public');

            $images[] = new Image(['img_src' => $path]);
        }
        $product->images()->saveMany($images);

        return response()->json($product, 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId, $imageId)
    {
        $product = Product::with('images')->findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);
        $image->delete();

        return response()->json('deleted successfully');
    }
}
