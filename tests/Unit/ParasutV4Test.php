<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Unit;

use Theposeidonas\LaravelParasutApi\ParasutV4;
use Illuminate\Http\Client\Response;
use Orchestra\Testbench\TestCase;

class ParasutV4Test extends TestCase
{
    protected $parasut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parasut = new ParasutV4([
            'username' => 'test_username',
            'password' => 'test_password',
            'company_id' => 'test_company_id',
            'client_id' => 'test_client_id',
            'client_secret' => 'test_client_secret',
            'redirect_uri' => 'test_redirect_uri',
            'api_url' => 'https://api.parasut.com/v4/'
        ]);
    }

    public function test_instance_is_created_correctly()
    {
        $this->assertInstanceOf(ParasutV4::class, $this->parasut);
    }

    public function test_handle_response_successful()
    {
        $mockResponse = $this->createMock(Response::class);
        $mockResponse->method('successful')->willReturn(true);
        $mockResponse->method('body')->willReturn(json_encode(['data' => 'success']));
        $mockResponse->method('status')->willReturn(200);

        $result = $this->parasut->handleResponse($mockResponse);

        $this->assertTrue($result['success']);
        $this->assertFalse($result['error']);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('success', $result['body']->data);
    }

    public function test_handle_response_failure()
    {
        $mockResponse = $this->createMock(Response::class);
        $mockResponse->method('successful')->willReturn(false);
        $mockResponse->method('body')->willReturn(json_encode(['error' => 'Unauthorized']));
        $mockResponse->method('status')->willReturn(401);

        $result = $this->parasut->handleResponse($mockResponse);

        $this->assertFalse($result['success']);
        $this->assertTrue($result['error']);
        $this->assertEquals(401, $result['status']);
        $this->assertEquals('Unauthorized', $result['body']->error);
    }
}
