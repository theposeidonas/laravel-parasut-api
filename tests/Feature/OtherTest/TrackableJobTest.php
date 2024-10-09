<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\OtherTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Other\TrackableJob;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class TrackableJobTest extends BaseTest
{
    protected TrackableJob $trackableJob;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trackableJob = new TrackableJob(config('parasut'));
    }

    public function test_show_trackable_job()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/trackable_jobs/1' => Http::response([
                'data' => [
                    'id' => '1',
                    'type' => 'trackable_job',
                    'attributes' => ['status' => 'completed'],
                ],
            ], 200),
        ]);

        $response = $this->trackableJob->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('completed', $response['body']->data->attributes->status);
    }
}
