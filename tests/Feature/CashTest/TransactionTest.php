<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\CashTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Cash\Transaction;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class TransactionTest extends BaseTest
{
    protected Transaction $transaction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transaction = new Transaction(config('parasut'));
    }

    public function test_show_transaction()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/transactions/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'transaction', 'attributes' => ['amount' => 100]],
            ], 200),
        ]);

        $response = $this->transaction->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('transaction', $response['body']->data->type);
        $this->assertEquals(100, $response['body']->data->attributes->amount);
    }

    public function test_delete_transaction()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/transactions/1' => Http::response([], 204),
        ]);

        $response = $this->transaction->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
