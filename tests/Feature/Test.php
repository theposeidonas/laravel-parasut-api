<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature;

use Orchestra\Testbench\TestCase;
use Theposeidonas\LaravelParasutApi\Facades\Parasut;

class Test extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }
    public function getName(bool $withDataSet = true): string
    {
        return 'simple_test';
    }

    /**
     * @param $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return ['Theposeidonas\LaravelParasutApi\ParasutServiceProvider'];
    }


    /** @test */
    public function try()
    {
        $this->assertTrue(Parasut::Customer()->index()['success']);
    }
}
