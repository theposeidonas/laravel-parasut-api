<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\FormalizationTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Formalization\Inbox;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class InboxTest extends BaseTest
{
    protected Inbox $inbox;

    protected function setUp(): void
    {
        parent::setUp();
        $this->inbox = new Inbox(config('parasut'));
    }

    public function test_index_inbox()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/e_invoice_inboxes?filter%5Bvkn%5D=1234567890' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'e_invoice_inbox', 'attributes' => ['vkn' => 1234567890]],
                    ['id' => '2', 'type' => 'e_invoice_inbox', 'attributes' => ['vkn' => 1257654321]],
                ],
            ], 200),
        ]);

        $response = $this->inbox->index(['filter' => ['vkn' => 1234567890]]);
        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals(1234567890, $response['body']->data[0]->attributes->vkn);
    }
}
