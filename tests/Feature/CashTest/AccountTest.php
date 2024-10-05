<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\CashTest;

use Theposeidonas\LaravelParasutApi\Models\Cash\Account;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class AccountTest extends BaseTest
{
    protected Account $account;

    protected function setUp(): void
    {
        parent::setUp();
        $this->account = new Account(config('parasut'));
    }

    public function test_index()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/accounts' => Http::response([
                'data' => [
                    ['id' => '1', 'name' => 'Test Account'],
                    ['id' => '2', 'name' => 'Another Account']
                ]
            ], 200)
        ]);

        $response = $this->account->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Test Account', $response['body']->data[0]->name);
    }

    public function test_show()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/accounts/1' => Http::response([
                'data' => ['id' => '1', 'name' => 'Test Account']
            ], 200)
        ]);

        $response = $this->account->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Test Account', $response['body']->data->name);
    }

    public function test_create()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/accounts' => Http::response([
                'data' => ['id' => '1', 'name' => 'New Account']
            ], 201)
        ]);

        $response = $this->account->create(['name' => 'New Account']);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Account', $response['body']->data->name);
    }

    public function test_edit()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/accounts/1' => Http::response([
                'data' => ['id' => '1', 'name' => 'Updated Account']
            ], 200)
        ]);

        $response = $this->account->edit('1', ['name' => 'Updated Account']);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Account', $response['body']->data->name);
    }

    public function test_delete()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/accounts/1' => Http::response([], 204)
        ]);

        $response = $this->account->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
