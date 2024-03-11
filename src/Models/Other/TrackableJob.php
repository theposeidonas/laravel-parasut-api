<?php

namespace Theposeidonas\LaravelParasutApi\Models\Other;

use Illuminate\Support\Facades\Http;

/**
 * API HOME
 * https://apidocs.parasut.com/#tag/showTrackableJob
 */
class TrackableJob
{
    /**
     * @var string
     */
    private string $token;
    /**
     * @var array
     */
    private array $config;
    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @param $token
     * @param $config
     */
    public function __construct($token, $config)
    {
        $this->token = $token;
        $this->config = $config;
        $this->baseUrl = 'https://api.parasut.com/v4/'.$this->config['company_id'].'/trackable_jobs';
    }

    /**
     * @return array
     */
    public function show($id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->baseUrl.'/'.$id);
        return $this->handleResponse($response);
    }

    /**
     * @param $response
     * @return array
     */
    public function handleResponse($response): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'error' => false,
                'body' => json_decode($response->body()),
                'status' => $response->status()
            ];
        } else {
            return [
                'success' => false,
                'error' => true,
                'body' => json_decode($response->body()),
                'status' => $response->status(),
            ];
        }

    }
}