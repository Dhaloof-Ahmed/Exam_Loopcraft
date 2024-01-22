<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ShopProduct;

class ShopProductTest extends TestCase
{
    public function testProductList()
    {
        $response = $this->json('GET', '/api/products');
        $response->assertStatus(200);
    }

    public function testProductCreate()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 19.99,
            // Add other fields as needed
        ];

        $response = $this->json('POST', '/api/products', $productData);
        $response->assertStatus(201);
    }

    public function testProductUpdate()
    {
        $product = ShopProduct::create([
            'name' => 'Old Product',
            'description' => 'Old description',
            'price' => 29.99,
            // Add other fields as needed
        ]);

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 39.99,
            // Add other fields as needed
        ];

        $response = $this->json('PUT', "/api/products/{$product->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function testProductDelete()
    {
        $product = ShopProduct::create([
            'name' => 'Product to be deleted',
            'description' => 'Description for deletion',
            'price' => 49.99,
            // Add other fields as needed
        ]);

        $response = $this->json('DELETE', "/api/products/{$product->id}");
        $response->assertStatus(200);
    }
}
