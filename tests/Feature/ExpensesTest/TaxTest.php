<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\ExpensesTest;

use Theposeidonas\LaravelParasutApi\Models\Expenses\Tax;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class TaxTest extends BaseTest
{
    protected Tax $tax;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tax = new Tax(config('parasut'));
    }

    public function test_index_taxes()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/taxes' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'tax', 'attributes' => ['amount' => 100]],
                    ['id' => '2', 'type' => 'tax', 'attributes' => ['amount' => 200]],
                ]
            ], 200)
        ]);

        $response = $this->tax->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals(100, $response['body']->data[0]->attributes->amount);
    }

    public function test_create_tax()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/taxes' => Http::response([
                'data' => ['id' => '1', 'type' => 'tax', 'attributes' => ['amount' => 150]]
            ], 201)
        ]);

        $response = $this->tax->create(['amount' => 150], []);

        $this->assertTrue($response['success']);
        $this->assertEquals(150, $response['body']->data->attributes->amount);
    }

    public function test_show_tax()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/taxes/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'tax', 'attributes' => ['amount' => 100]]
            ], 200)
        ]);

        $response = $this->tax->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(100, $response['body']->data->attributes->amount);
    }

    public function test_edit_tax()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/taxes/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'tax', 'attributes' => ['amount' => 200]]
            ], 200)
        ]);

        $response = $this->tax->edit('1', ['amount' => 200], []);

        $this->assertTrue($response['success']);
        $this->assertEquals(200, $response['body']->data->attributes->amount);
    }

    public function test_delete_tax()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/taxes/1' => Http::response([], 204)
        ]);

        $response = $this->tax->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
