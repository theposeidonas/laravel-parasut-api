<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\SalesTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Sales\Customer;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class CustomerTest extends BaseTest
{
    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = new Customer(config('parasut'));
    }

    public function test_index_customers()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'Customer 1']],
                    ['id' => '2', 'type' => 'contact', 'attributes' => ['name' => 'Customer 2']],
                ],
            ], 200),
        ]);

        $response = $this->customer->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Customer 1', $response['body']->data[0]->attributes->name);
    }

    public function test_create_customer()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts' => Http::response([
                'data' => ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'New Customer']],
            ], 201),
        ]);

        $response = $this->customer->create(['name' => 'New Customer'], []);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Customer', $response['body']->data->attributes->name);
    }

    public function test_show_customer()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'Customer 1']],
            ], 200),
        ]);

        $response = $this->customer->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Customer 1', $response['body']->data->attributes->name);
    }

    public function test_edit_customer()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'contact', 'attributes' => ['name' => 'Updated Customer']],
            ], 200),
        ]);

        $response = $this->customer->edit('1', ['name' => 'Updated Customer'], []);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Customer', $response['body']->data->attributes->name);
    }

    public function test_delete_customer()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/contacts/1' => Http::response([], 204),
        ]);

        $response = $this->customer->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
