<?php

namespace Theposeidonas\LaravelParasutApi\Models\Formalization;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * E-Arşiv
 * https://apidocs.parasut.com/#tag/EArchives
 */
class EArchive extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/e_archives';
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl, $data);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return array
     */
    public function show(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:sales_invoice'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id, $parameters);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @return array
     */
    public function showPDF(string $id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id.'/pdf');

        return [
            'success' => $response->successful(),
            'error' => !$response->successful(),
            'body' => $response->body(),
            'status' => $response->status()
        ];
    }

}