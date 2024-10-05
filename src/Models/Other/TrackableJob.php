<?php

namespace Theposeidonas\LaravelParasutApi\Models\Other;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * API HOME
 * https://apidocs.parasut.com/#tag/TrackableJobs
 */
class TrackableJob extends ParasutV4
{
    /**
     * @var string
     */
    private string $serviceUrl;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/trackable_jobs';
    }

    /**
     * @param string $id
     * @return array
     */
    public function show(string $id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id);
        return $this->handleResponse($response);
    }

}