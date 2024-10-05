<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\StockTest;

use Theposeidonas\LaravelParasutApi\Models\Stock\Warehouse;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class WarehouseTest extends BaseTest
{
    protected Warehouse $warehouse;

    protected function setUp(): void
    {
        parent::setUp();
        $this->warehouse = new Warehouse(config('parasut'));
    }

    public function test_index_warehouses()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/warehouses' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'warehouse', 'attributes' => ['name' => 'Warehouse 1']],
                    ['id' => '2', 'type' => 'warehouse', 'attributes' => ['name' => 'Warehouse 2']],
                ]
            ], 200)
        ]);

        $response = $this->warehouse->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Warehouse 1', $response['body']->data[0]->attributes->name);
    }

    public function test_create_warehouse()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/warehouses' => Http::response([
                'data' => ['id' => '1', 'type' => 'warehouse', 'attributes' => ['name' => 'New Warehouse']]
            ], 201)
        ]);

        $response = $this->warehouse->create(['name' => 'New Warehouse']);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Warehouse', $response['body']->data->attributes->name);
    }

    public function test_show_warehouse()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/warehouses/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'warehouse', 'attributes' => ['name' => 'Warehouse 1']]
            ], 200)
        ]);

        $response = $this->warehouse->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Warehouse 1', $response['body']->data->attributes->name);
    }

    public function test_edit_warehouse()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/warehouses/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'warehouse', 'attributes' => ['name' => 'Updated Warehouse']]
            ], 200)
        ]);

        $response = $this->warehouse->edit('1', ['name' => 'Updated Warehouse']);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Warehouse', $response['body']->data->attributes->name);
    }

    public function test_delete_warehouse()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/warehouses/1' => Http::response([], 204)
        ]);

        $response = $this->warehouse->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
