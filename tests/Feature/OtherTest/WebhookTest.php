<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\OtherTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Other\Webhook;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class WebhookTest extends BaseTest
{
    protected Webhook $webhook;

    protected function setUp(): void
    {
        parent::setUp();
        $this->webhook = new Webhook(config('parasut'));
    }

    public function test_index_webhooks()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/webhooks' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'webhook', 'attributes' => ['url' => 'https://example.com/webhook1']],
                    ['id' => '2', 'type' => 'webhook', 'attributes' => ['url' => 'https://example.com/webhook2']],
                ],
            ], 200),
        ]);

        $response = $this->webhook->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('https://example.com/webhook1', $response['body']->data[0]->attributes->url);
    }

    public function test_create_webhook()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/webhooks' => Http::response([
                'data' => ['id' => '1', 'type' => 'webhook', 'attributes' => ['url' => 'https://example.com/webhook1']],
            ], 201),
        ]);

        $response = $this->webhook->create(['url' => 'https://example.com/webhook1']);

        $this->assertTrue($response['success']);
        $this->assertEquals('https://example.com/webhook1', $response['body']->data->attributes->url);
    }

    public function test_edit_webhook()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/webhooks/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'webhook', 'attributes' => ['url' => 'https://example.com/updated_webhook']],
            ], 200),
        ]);

        $response = $this->webhook->edit('1', ['url' => 'https://example.com/updated_webhook']);

        $this->assertTrue($response['success']);
        $this->assertEquals('https://example.com/updated_webhook', $response['body']->data->attributes->url);
    }

    public function test_delete_webhook()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/webhooks/1' => Http::response([], 204),
        ]);

        $response = $this->webhook->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
