<?php

namespace Theposeidonas\LaravelParasutApi\Models\Other;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Vergi
 * https://apidocs.parasut.com/#tag/Webhooks
 */
class Webhook extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/webhooks';
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl);
        return $this->handleResponse($response);
    }

    /**
     * @param array $data
     * @return array
     */
    public function create($data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl, $data);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $data
     * @return array
     */
    public function edit(string $id, $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->serviceUrl.'/'.$id, $data);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @return array
     */
    public function delete(string $id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->delete($this->serviceUrl.'/'.$id);
        return $this->handleResponse($response);
    }

}