<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\SalesTest;

use Theposeidonas\LaravelParasutApi\Models\Sales\Bill;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class BillTest extends BaseTest
{
    protected Bill $bill;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bill = new Bill(config('parasut'));
    }

    public function test_index_bills()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/sales_invoices' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'sales_invoice', 'attributes' => ['amount' => 1000]],
                    ['id' => '2', 'type' => 'sales_invoice', 'attributes' => ['amount' => 2000]],
                ]
            ], 200)
        ]);

        $response = $this->bill->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals(1000, $response['body']->data[0]->attributes->amount);
    }

    public function test_create_bill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/sales_invoices' => Http::response([
                'data' => ['id' => '1', 'type' => 'sales_invoice', 'attributes' => ['amount' => 1500]]
            ], 201)
        ]);

        $response = $this->bill->create(['amount' => 1500]);

        $this->assertTrue($response['success']);
        $this->assertEquals(1500, $response['body']->data->attributes->amount);
    }

    public function test_show_bill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/sales_invoices/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'sales_invoice', 'attributes' => ['amount' => 1000]]
            ], 200)
        ]);

        $response = $this->bill->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(1000, $response['body']->data->attributes->amount);
    }

    public function test_edit_bill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/sales_invoices/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'sales_invoice', 'attributes' => ['amount' => 2000]]
            ], 200)
        ]);

        $response = $this->bill->edit('1', ['amount' => 2000]);

        $this->assertTrue($response['success']);
        $this->assertEquals(2000, $response['body']->data->attributes->amount);
    }

    public function test_delete_bill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/sales_invoices/1' => Http::response([], 204)
        ]);

        $response = $this->bill->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
