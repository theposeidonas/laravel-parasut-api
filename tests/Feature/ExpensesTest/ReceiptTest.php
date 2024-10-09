<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\ExpensesTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Receipt;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class ReceiptTest extends BaseTest
{
    protected Receipt $receipt;

    protected function setUp(): void
    {
        parent::setUp();
        $this->receipt = new Receipt(config('parasut'));
    }

    public function test_index_receipts()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/purchase_bills' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['amount' => 100]],
                    ['id' => '2', 'type' => 'purchase_bill', 'attributes' => ['amount' => 200]],
                ],
            ], 200),
        ]);

        $response = $this->receipt->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals(100, $response['body']->data[0]->attributes->amount);
    }

    // Used wildcard '*' in Http::fake() because Http::fake() cannot handle URLs with '#' character properly.
    public function test_create_basic_receipt()
    {
        Http::fake([
            '*' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['amount' => 150]],
            ], 201),
        ]);

        $response = $this->receipt->createBasic(['amount' => 150]);

        $this->assertTrue($response['success']);
        $this->assertEquals(150, $response['body']->data->attributes->amount);
    }

    public function test_create_detailed_receipt()
    {
        Http::fake([
            '*' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['amount' => 250]],
            ], 201),
        ]);

        $response = $this->receipt->createDetailed(['amount' => 250]);

        $this->assertTrue($response['success']);
        $this->assertEquals(250, $response['body']->data->attributes->amount);
    }

    public function test_show_receipt()
    {
        Http::fake([
            '*' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['amount' => 100]],
            ], 200),
        ]);

        $response = $this->receipt->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(100, $response['body']->data->attributes->amount);
    }

    public function test_edit_basic_receipt()
    {
        Http::fake([
            '*' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['amount' => 300]],
            ], 200),
        ]);

        $response = $this->receipt->editBasic('1', ['amount' => 300]);

        $this->assertTrue($response['success']);
        $this->assertEquals(300, $response['body']->data->attributes->amount);
    }

    public function test_edit_detailed_receipt()
    {
        Http::fake([
            '*' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['amount' => 300]],
            ], 200),
        ]);

        $response = $this->receipt->editDetailed('1', ['amount' => 300]);
        $this->assertTrue($response['success']);
        $this->assertEquals(300, $response['body']->data->attributes->amount);
    }

    public function test_delete_receipt()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/purchase_bills/1' => Http::response([], 204),
        ]);

        $response = $this->receipt->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }

    public function test_archive_receipt()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/purchase_bills/1/archive' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['archived' => true]],
            ], 200),
        ]);

        $response = $this->receipt->archive('1');

        $this->assertTrue($response['success']);
        $this->assertTrue($response['body']->data->attributes->archived);
    }

    public function test_unarchive_receipt()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/purchase_bills/1/unarchive' => Http::response([
                'data' => ['id' => '1', 'type' => 'purchase_bill', 'attributes' => ['archived' => false]],
            ], 200),
        ]);

        $response = $this->receipt->unarchive('1');

        $this->assertTrue($response['success']);
        $this->assertFalse($response['body']->data->attributes->archived);
    }
}
