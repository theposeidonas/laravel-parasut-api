<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\StockTest;

use Theposeidonas\LaravelParasutApi\Models\Stock\Waybill;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class WaybillTest extends BaseTest
{
    protected Waybill $waybill;

    protected function setUp(): void
    {
        parent::setUp();
        $this->waybill = new Waybill(config('parasut'));
    }

    public function test_index_waybills()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/shipment_documents' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'shipment_document', 'attributes' => ['issue_date' => '2024-01-01']],
                    ['id' => '2', 'type' => 'shipment_document', 'attributes' => ['issue_date' => '2024-01-02']],
                ]
            ], 200)
        ]);

        $response = $this->waybill->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('2024-01-01', $response['body']->data[0]->attributes->issue_date);
    }

    public function test_create_waybill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/shipment_documents' => Http::response([
                'data' => ['id' => '1', 'type' => 'shipment_document', 'attributes' => ['issue_date' => '2024-01-01']]
            ], 201)
        ]);

        $response = $this->waybill->create(['issue_date' => '2024-01-01']);

        $this->assertTrue($response['success']);
        $this->assertEquals('2024-01-01', $response['body']->data->attributes->issue_date);
    }

    public function test_show_waybill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/shipment_documents/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'shipment_document', 'attributes' => ['issue_date' => '2024-01-01']]
            ], 200)
        ]);

        $response = $this->waybill->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('2024-01-01', $response['body']->data->attributes->issue_date);
    }

    public function test_edit_waybill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/shipment_documents/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'shipment_document', 'attributes' => ['issue_date' => '2024-01-02']]
            ], 200)
        ]);

        $response = $this->waybill->edit('1', ['issue_date' => '2024-01-02']);

        $this->assertTrue($response['success']);
        $this->assertEquals('2024-01-02', $response['body']->data->attributes->issue_date);
    }

    public function test_delete_waybill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/shipment_documents/1' => Http::response([], 204)
        ]);

        $response = $this->waybill->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
