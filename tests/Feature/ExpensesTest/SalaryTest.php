<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\ExpensesTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Salary;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class SalaryTest extends BaseTest
{
    protected Salary $salary;

    protected function setUp(): void
    {
        parent::setUp();
        $this->salary = new Salary(config('parasut'));
    }

    public function test_index_salaries()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'salary', 'attributes' => ['net_total' => 1000]],
                    ['id' => '2', 'type' => 'salary', 'attributes' => ['net_total' => 2000]],
                ],
            ], 200),
        ]);

        $response = $this->salary->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals(1000, $response['body']->data[0]->attributes->net_total);
    }

    public function test_create_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries' => Http::response([
                'data' => ['id' => '1', 'type' => 'salary', 'attributes' => ['net_total' => 1500]],
            ], 201),
        ]);

        $response = $this->salary->create(['net_total' => 1500]);

        $this->assertTrue($response['success']);
        $this->assertEquals(1500, $response['body']->data->attributes->net_total);
    }

    public function test_show_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'salary', 'attributes' => ['net_total' => 1000]],
            ], 200),
        ]);

        $response = $this->salary->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(1000, $response['body']->data->attributes->net_total);
    }

    public function test_edit_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'salary', 'attributes' => ['net_total' => 2000]],
            ], 200),
        ]);

        $response = $this->salary->edit('1', ['net_total' => 2000]);

        $this->assertTrue($response['success']);
        $this->assertEquals(2000, $response['body']->data->attributes->net_total);
    }

    public function test_delete_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries/1' => Http::response([], 204),
        ]);

        $response = $this->salary->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }

    public function test_archive_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries/1/archive' => Http::response([
                'data' => ['id' => '1', 'type' => 'salary', 'attributes' => ['archived' => true]],
            ], 200),
        ]);

        $response = $this->salary->archive('1');

        $this->assertTrue($response['success']);
        $this->assertTrue($response['body']->data->attributes->archived);
    }

    public function test_unarchive_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries/1/unarchive' => Http::response([
                'data' => ['id' => '1', 'type' => 'salary', 'attributes' => ['archived' => false]],
            ], 200),
        ]);

        $response = $this->salary->unarchive('1');

        $this->assertTrue($response['success']);
        $this->assertFalse($response['body']->data->attributes->archived);
    }

    public function test_pay_salary()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/salaries/1/payments' => Http::response([
                'data' => ['id' => '1', 'type' => 'payment', 'attributes' => ['amount' => 1000]],
            ], 200),
        ]);

        $response = $this->salary->pay('1', ['amount' => 1000]);

        $this->assertTrue($response['success']);
        $this->assertEquals(1000, $response['body']->data->attributes->amount);
    }
}
