<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Unit;

use Theposeidonas\LaravelParasutApi\ParasutServiceProvider;
use Theposeidonas\LaravelParasutApi\ParasutV4;

class ParasutServiceProviderTest extends BaseTest
{
    protected function getPackageProviders($app): array
    {
        return [ParasutServiceProvider::class];
    }

    public function test_service_provider_registers_parasut_v4_instance()
    {
        $this->assertInstanceOf(
            ParasutV4::class,
            $this->app->make(ParasutV4::class)
        );
    }

    public function test_configuration_values_are_set()
    {
        $config = $this->app['config']->get('parasut');
        $this->assertNotEmpty($config['username']);
        $this->assertNotEmpty($config['password']);
        $this->assertNotEmpty($config['company_id']);
        $this->assertNotEmpty($config['client_id']);
        $this->assertNotEmpty($config['client_secret']);
    }
}
