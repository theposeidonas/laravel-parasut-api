<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Auth;

class ParasutAuthenticationTest extends BaseTest

{
    public function test_get_token_with_cached_token()
    {
        Cache::shouldReceive('get')
            ->once()
            ->with('parachute_token')
            ->andReturn('cached_token');

        $auth = new Auth(config('parasut'));

        $token = $auth->getToken();

        $this->assertEquals('cached_token', $token);
    }

    public function test_get_token_without_cached_token()
    {
        Cache::shouldReceive('get')
            ->once()
            ->with('parachute_token')
            ->andReturn(null);

        Cache::shouldReceive('put')
            ->once()
            ->with('parachute_token', 'new_access_token', \Mockery::any());

        Http::fake([
            'https://api.parasut.com/oauth/token' => Http::response([
                'access_token' => 'new_access_token',
                'expires_in' => 3600,
            ], 200)
        ]);

        $auth = new Auth(config('parasut'));

        $token = $auth->getToken();

        $this->assertEquals('new_access_token', $token);
    }

    public function test_fetch_new_token_fails()
    {
        Cache::shouldReceive('get')
            ->once()
            ->with('parachute_token')
            ->andReturn(null);

        Http::fake([
            'https://api.parasut.com/oauth/token' => Http::response(null, 400)
        ]);

        $auth = new Auth(config('parasut'));

        $token = $auth->getToken();

        $this->assertStringContainsString('Error', $token);
    }
}
