<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTest extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (file_exists(__DIR__.'/../../.env')) {
            \Dotenv\Dotenv::createImmutable(__DIR__.'/../../')->load();
        }

        config()->set('parasut.username', env('PARASUT_USERNAME', 'test_username'));
        config()->set('parasut.password', env('PARASUT_PASSWORD', 'test_password'));
        config()->set('parasut.company_id', env('PARASUT_COMPANY_ID', 'test_company'));
        config()->set('parasut.client_id', env('PARASUT_CLIENT_ID', 'test_client_id'));
        config()->set('parasut.client_secret', env('PARASUT_CLIENT_SECRET', 'test_secret'));
        config()->set('parasut.redirect_uri', env('PARASUT_REDIRECT_URI', 'https://localhost'));
        config()->set('parasut.api_url', env('PARASUT_API_URL', 'https://api.parasut.com/v4/'));

        Cache::put('parachute_token', 'test_token', 3600);
    }

    protected function getPackageProviders($app): array
    {
        return ['Theposeidonas\LaravelParasutApi\ParasutServiceProvider'];
    }
}
