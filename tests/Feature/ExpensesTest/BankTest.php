<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\ExpensesTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Bank;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class BankTest extends BaseTest
{
    protected Bank $bank;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bank = new Bank(config('parasut'));
    }

    public function test_create_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees' => Http::response([
                'data' => ['id' => '1', 'type' => 'bank_fee', 'attributes' => ['amount' => 100]],
            ], 201),
        ]);

        $response = $this->bank->create(['name' => 'New Bank Fee']);

        $this->assertTrue($response['success']);
        $this->assertEquals('bank_fee', $response['body']->data->type);
        $this->assertEquals(100, $response['body']->data->attributes->amount);
    }

    public function test_show_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'bank_fee', 'attributes' => ['amount' => 100]],
            ], 200),
        ]);

        $response = $this->bank->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('bank_fee', $response['body']->data->type);
        $this->assertEquals(100, $response['body']->data->attributes->amount);
    }

    public function test_edit_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'bank_fee', 'attributes' => ['amount' => 150]],
            ], 200),
        ]);

        $response = $this->bank->edit('1', ['amount' => 150]);

        $this->assertTrue($response['success']);
        $this->assertEquals(150, $response['body']->data->attributes->amount);
    }

    public function test_delete_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees/1' => Http::response([], 204),
        ]);

        $response = $this->bank->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }

    public function test_archive_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees/1/archive' => Http::response([
                'data' => ['id' => '1', 'type' => 'bank_fee', 'attributes' => ['archived' => true]],
            ], 200),
        ]);

        $response = $this->bank->archive('1');

        $this->assertTrue($response['success']);
        $this->assertTrue($response['body']->data->attributes->archived);
    }

    public function test_unarchive_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees/1/unarchive' => Http::response([
                'data' => ['id' => '1', 'type' => 'bank_fee', 'attributes' => ['archived' => false]],
            ], 200),
        ]);

        $response = $this->bank->unarchive('1');

        $this->assertTrue($response['success']);
        $this->assertFalse($response['body']->data->attributes->archived);
    }

    public function test_pay_bank_fee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/bank_fees/1/payments' => Http::response([
                'data' => ['id' => '1', 'type' => 'payment', 'attributes' => ['amount' => 100]],
            ], 200),
        ]);

        $response = $this->bank->pay('1', ['amount' => 100]);

        $this->assertTrue($response['success']);
        $this->assertEquals(100, $response['body']->data->attributes->amount);
    }
}
