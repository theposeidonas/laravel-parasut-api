<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\StockTest;

use Theposeidonas\LaravelParasutApi\Models\Stock\Product;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class ProductTest extends BaseTest
{
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product(config('parasut'));
    }

    public function test_index_products()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/products' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'product', 'attributes' => ['name' => 'Product 1']],
                    ['id' => '2', 'type' => 'product', 'attributes' => ['name' => 'Product 2']],
                ]
            ], 200)
        ]);

        $response = $this->product->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Product 1', $response['body']->data[0]->attributes->name);
    }

    public function test_create_product()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/products' => Http::response([
                'data' => ['id' => '1', 'type' => 'product', 'attributes' => ['name' => 'New Product']]
            ], 201)
        ]);

        $response = $this->product->create(['name' => 'New Product']);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Product', $response['body']->data->attributes->name);
    }

    public function test_show_product()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/products/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'product', 'attributes' => ['name' => 'Product 1']]
            ], 200)
        ]);

        $response = $this->product->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Product 1', $response['body']->data->attributes->name);
    }

    public function test_edit_product()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/products/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'product', 'attributes' => ['name' => 'Updated Product']]
            ], 200)
        ]);

        $response = $this->product->edit('1', ['name' => 'Updated Product']);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Product', $response['body']->data->attributes->name);
    }

    public function test_delete_product()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/products/1' => Http::response([], 204)
        ]);

        $response = $this->product->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }

    public function test_inventory_product()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/products/1/inventory_levels' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'inventory_level', 'attributes' => ['stock_count' => 50]],
                    ['id' => '2', 'type' => 'inventory_level', 'attributes' => ['stock_count' => 30]],
                ]
            ], 200)
        ]);

        $response = $this->product->inventory('1');

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals(50, $response['body']->data[0]->attributes->stock_count);
    }
}
