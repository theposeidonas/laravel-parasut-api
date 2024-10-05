<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\FormalizationTest;

use Theposeidonas\LaravelParasutApi\Models\Formalization\EBill;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class EBillTest extends BaseTest
{
    protected EBill $eBill;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eBill = new EBill(config('parasut'));
    }

    public function test_create_ebill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_invoices' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_invoice', 'attributes' => ['status' => 'created']]
            ], 201)
        ]);

        $response = $this->eBill->create(['invoice_data' => 'test_data']);

        $this->assertTrue($response['success']);
        $this->assertEquals('created', $response['body']->data->attributes->status);
    }

    public function test_show_ebill()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_invoices/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_invoice', 'attributes' => ['status' => 'approved']]
            ], 200)
        ]);

        $response = $this->eBill->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('approved', $response['body']->data->attributes->status);
    }

    public function test_show_ebill_pdf()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_invoices/1/pdf' => Http::response('PDF content', 200)
        ]);

        $response = $this->eBill->showPDF('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('PDF content', $response['body']);
    }
}