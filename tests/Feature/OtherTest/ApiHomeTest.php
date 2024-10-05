<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\OtherTest;

use Theposeidonas\LaravelParasutApi\Models\Other\ApiHome;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class ApiHomeTest extends BaseTest
{
    protected ApiHome $apiHome;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiHome = new ApiHome(config('parasut'));
    }

    public function test_index_api_home()
    {
        Http::fake([
            config('parasut.api_url').'me' => Http::response([
                'data' => [
                    'id' => '1',
                    'type' => 'api_home',
                    'attributes' => ['user' => 'Test User']
                ]
            ], 200)
        ]);

        $response = $this->apiHome->index();

        $this->assertTrue($response['success']);
        $this->assertEquals('Test User', $response['body']->data->attributes->user);
    }
}
