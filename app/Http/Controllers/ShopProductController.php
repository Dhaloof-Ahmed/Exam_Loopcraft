<?php

namespace App\Http\Controllers;

use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ShopProductController extends Controller
{
    public function index()
    {
        $products = ShopProduct::all();
        return response()->json(['products' => $products]);
    }

    public function show($id)
    {
        $product = ShopProduct::find($id);
        return response()->json(['product' => $product]);
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationRules();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = ShopProduct::create($validator->validated());

        // Handle image upload
        $this->handleImageUpload($request, $product);

        return response()->json(['product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->getValidationRules($id);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = ShopProduct::findOrFail($id);
        $product->update($validator->validated());

        // Handle image upload
        $this->handleImageUpload($request, $product);

        return response()->json(['product' => $product]);
    }

    public function destroy($id)
    {
        $product = ShopProduct::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    protected function getValidationRules($productId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            // Add other validation rules for your fields
        ];

        // Add unique validation for update
        if ($productId !== null) {
            $rules['name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('shop_products')->ignore($productId),
            ];
        }

        return Validator::make(request()->all(), $rules);
    }

    protected function handleImageUpload(Request $request, ShopProduct $product)
    {
        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('product-images');
        }
    }
}
