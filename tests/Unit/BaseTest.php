<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Unit;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTest extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (file_exists(__DIR__.'/../../.env')) {
            \Dotenv\Dotenv::createImmutable(__DIR__.'/../../')->load();
        }

        config()->set('parasut.username', env('PARASUT_USERNAME'));
        config()->set('parasut.password', env('PARASUT_PASSWORD'));
        config()->set('parasut.company_id', env('PARASUT_COMPANY_ID'));
        config()->set('parasut.client_id', env('PARASUT_CLIENT_ID'));
        config()->set('parasut.client_secret', env('PARASUT_CLIENT_SECRET'));
        config()->set('parasut.redirect_uri', env('PARASUT_REDIRECT_URI'));
        config()->set('parasut.api_url', env('PARASUT_API_URL', 'https://api.parasut.com/v4/'));
    }

    protected function getPackageProviders($app): array
    {
        return ['Theposeidonas\LaravelParasutApi\ParasutServiceProvider'];
    }
}
