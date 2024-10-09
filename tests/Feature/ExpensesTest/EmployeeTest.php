<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\ExpensesTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Employee;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class EmployeeTest extends BaseTest
{
    protected Employee $employee;

    protected function setUp(): void
    {
        parent::setUp();
        $this->employee = new Employee(config('parasut'));
    }

    public function test_create_employee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/employees' => Http::response([
                'data' => ['id' => '1', 'type' => 'employee', 'attributes' => ['name' => 'John Doe']],
            ], 201),
        ]);

        $response = $this->employee->create(['name' => 'John Doe']);

        $this->assertTrue($response['success']);
        $this->assertEquals('employee', $response['body']->data->type);
        $this->assertEquals('John Doe', $response['body']->data->attributes->name);
    }

    public function test_show_employee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/employees/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'employee', 'attributes' => ['name' => 'John Doe']],
            ], 200),
        ]);

        $response = $this->employee->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('employee', $response['body']->data->type);
        $this->assertEquals('John Doe', $response['body']->data->attributes->name);
    }

    public function test_edit_employee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/employees/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'employee', 'attributes' => ['name' => 'Jane Doe']],
            ], 200),
        ]);

        $response = $this->employee->edit('1', ['name' => 'Jane Doe']);

        $this->assertTrue($response['success']);
        $this->assertEquals('Jane Doe', $response['body']->data->attributes->name);
    }

    public function test_delete_employee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/employees/1' => Http::response([], 204),
        ]);

        $response = $this->employee->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }

    public function test_archive_employee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/employees/1/archive' => Http::response([
                'data' => ['id' => '1', 'type' => 'employee', 'attributes' => ['archived' => true]],
            ], 200),
        ]);

        $response = $this->employee->archive('1');

        $this->assertTrue($response['success']);
        $this->assertTrue($response['body']->data->attributes->archived);
    }

    public function test_unarchive_employee()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/employees/1/unarchive' => Http::response([
                'data' => ['id' => '1', 'type' => 'employee', 'attributes' => ['archived' => false]],
            ], 200),
        ]);

        $response = $this->employee->unarchive('1');

        $this->assertTrue($response['success']);
        $this->assertFalse($response['body']->data->attributes->archived);
    }
}
