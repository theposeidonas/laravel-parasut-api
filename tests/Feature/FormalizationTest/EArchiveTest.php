<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\FormalizationTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Formalization\EArchive;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class EArchiveTest extends BaseTest
{
    protected EArchive $eArchive;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eArchive = new EArchive(config('parasut'));
    }

    public function test_create_earchive()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_archives' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_archive', 'attributes' => ['status' => 'sent']],
            ], 201),
        ]);

        $response = $this->eArchive->create(['invoice_data' => 'test_data']);

        $this->assertTrue($response['success']);
        $this->assertEquals('sent', $response['body']->data->attributes->status);
    }

    public function test_show_earchive()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_archives/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_archive', 'attributes' => ['status' => 'approved']],
            ], 200),
        ]);

        $response = $this->eArchive->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('approved', $response['body']->data->attributes->status);
    }

    public function test_show_earchive_pdf()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_archives/1/pdf' => Http::response([
                'data' => ['id' => '1', 'type' => 'e_document_pdfs', 'attributes' => ['url' => 'pdf-url123.pdf', 'expires_at' => '2024-10-07T09:57:49Z']],
            ], 200),
        ]);

        $response = $this->eArchive->showPDF('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('pdf-url123.pdf', $response['body']->data->attributes->url);
    }
}
