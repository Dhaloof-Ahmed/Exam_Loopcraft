<?php

namespace App\Http\Controllers;

use App\Models\ShopBrand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShopBrandController extends Controller
{
    public function index()
    {
        $brands = ShopBrand::all();
        return response()->json(['brands' => $brands]);
    }

    public function show($id)
    {
        $brand = ShopBrand::find($id);
        return response()->json(['brand' => $brand]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
            // Add other validation rules for your fields
        ]);

        $brand = ShopBrand::create($validatedData);

        return response()->json(['brand' => $brand], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
            // Add other validation rules for your fields
        ]);

        $brand = ShopBrand::findOrFail($id);
        $brand->update($validatedData);

        return response()->json(['brand' => $brand]);
    }

    public function destroy($id)
    {
        $brand = ShopBrand::findOrFail($id);
        $brand->delete();

        return response()->json(['message' => 'Brand deleted successfully']);
    }
}

