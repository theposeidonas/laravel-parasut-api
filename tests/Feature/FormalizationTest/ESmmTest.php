<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\FormalizationTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Formalization\ESmm;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class ESmmTest extends BaseTest
{
    protected ESmm $eSmm;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eSmm = new ESmm(config('parasut'));
    }

    public function test_create_esmm()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_smms' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_smm', 'attributes' => ['status' => 'created']],
            ], 201),
        ]);

        $response = $this->eSmm->create(['smm_data' => 'test_data']);

        $this->assertTrue($response['success']);
        $this->assertEquals('created', $response['body']->data->attributes->status);
    }

    public function test_show_esmm()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_smms/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_smm', 'attributes' => ['status' => 'approved']],
            ], 200),
        ]);

        $response = $this->eSmm->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('approved', $response['body']->data->attributes->status);
    }

    public function test_show_esmm_pdf()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_smms/1/pdf' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_document_pdfs', 'attributes' => ['url' => 'pdf-url123.pdf', 'expires_at' => '2024-10-07T09:57:49Z']],
            ], 200),
        ]);

        $response = $this->eSmm->showPDF('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('pdf-url123.pdf', $response['body']->data->attributes->url);
    }
}
