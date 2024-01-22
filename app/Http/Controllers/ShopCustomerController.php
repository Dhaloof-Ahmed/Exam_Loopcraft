<?php

namespace App\Http\Controllers;

use App\Models\ShopProduct;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopProductController extends Controller
{
    public function index()
    {
        $products = ShopProduct::with('variations')->get();
        return response()->json(['products' => $products]);
    }

    public function show($id)
    {
        $product = ShopProduct::with('variations')->find($id);
        return response()->json(['product' => $product]);
    }

    public function store(Request $request)
    {
        $validator = $this->getProductValidationRules();
        $validator->merge($this->getVariationValidationRules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $productData = $validator->validated();
        $variationsData = $productData['variations'];
        unset($productData['variations']);

        $product = ShopProduct::create($productData);
        $product->variations()->createMany($variationsData);

        return response()->json(['product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->getProductValidationRules();
        $validator->merge($this->getVariationValidationRules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $productData = $validator->validated();
        $variationsData = $productData['variations'];
        unset($productData['variations']);

        $product = ShopProduct::findOrFail($id);
        $product->update($productData);
        $product->variations()->delete(); // Delete existing variations
        $product->variations()->createMany($variationsData);

        return response()->json(['product' => $product]);
    }

    public function destroy($id)
    {
        $product = ShopProduct::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    protected function getProductValidationRules()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpeg,jpg',
        ]);
    }

    protected function getVariationValidationRules()
{
    return Validator::make(request()->all(), [
        'variations.*.name' => 'required|string|max:255',
        'variations.*.price' => 'required|numeric',
        'variations.*.sku' => 'required|string|max:255',
        'variations.*.barcode' => 'nullable|string|max:255',
        'variations.*.description' => 'nullable|string',
        'variations.*.qty' => 'nullable|numeric',
        'variations.*.security_stock' => 'nullable|numeric',
        'variations.*.featured' => 'nullable|boolean',
        'variations.*.is_visible' => 'nullable|boolean',
        'variations.*.old_price' => 'nullable|numeric',
        'variations.*.cost' => 'nullable|numeric',
        'variations.*.enum' => 'nullable|in:deliverable,downloadable',
        'variations.*.backorder' => 'nullable|boolean',
        'variations.*.requires_shipping' => 'nullable|boolean',
        'variations.*.published_at' => 'nullable|date',
        'variations.*.seo_title' => 'nullable|string|max:60',
        'variations.*.seo_description' => 'nullable|string|max:160',
        'variations.*.weight_value' => 'nullable|numeric',
        'variations.*.weight_unit' => 'nullable|string|max:255',
        'variations.*.height_value' => 'nullable|numeric',
        'variations.*.height_unit' => 'nullable|string|max:255',
        'variations.*.width_value' => 'nullable|numeric',
        'variations.*.width_unit' => 'nullable|string|max:255',
        'variations.*.depth_value' => 'nullable|numeric',
        'variations.*.depth_unit' => 'nullable|string|max:255',
        'variations.*.volume_value' => 'nullable|numeric',
        'variations.*.volume_unit' => 'nullable|string|max:255',
    ]);
}

}
