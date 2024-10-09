<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\ExpensesTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Supplier;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class SupplierTest extends BaseTest
{
    protected Supplier $supplier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->supplier = new Supplier(config('parasut'));
    }

    public function test_index_suppliers()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'Supplier 1']],
                    ['id' => '2', 'type' => 'contact', 'attributes' => ['name' => 'Supplier 2']],
                ],
            ], 200),
        ]);

        $response = $this->supplier->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Supplier 1', $response['body']->data[0]->attributes->name);
    }

    public function test_create_supplier()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts' => Http::response([
                'data' => ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'New Supplier']],
            ], 201),
        ]);

        $response = $this->supplier->create(['name' => 'New Supplier'], []);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Supplier', $response['body']->data->attributes->name);
    }

    public function test_show_supplier()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'Supplier 1']],
            ], 200),
        ]);

        $response = $this->supplier->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Supplier 1', $response['body']->data->attributes->name);
    }

    public function test_edit_supplier()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'Updated Supplier']],
            ], 200),
        ]);

        $response = $this->supplier->edit('1', ['name' => 'Updated Supplier'], []);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Supplier', $response['body']->data->attributes->name);
    }

    public function test_delete_supplier()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts/1' => Http::response([], 204),
        ]);

        $response = $this->supplier->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
