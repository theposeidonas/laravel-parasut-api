<?php

namespace Theposeidonas\LaravelParasutApi\Models\Expenses;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Banka Gideri
 * https://apidocs.parasut.com/#tag/BankFees
 */
class Bank extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/bank_fees';
    }

    /**
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function create(array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,tags'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl. '?' . http_build_query($parameters), $data);
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
            'include' => 'nullable|string|in:category,tags'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id, $parameters);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function edit(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,tags'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->serviceUrl.'/'.$id.'?'.http_build_query($parameters), $data);
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

    /**
     * @param string $id
     * @param array $parameters
     * @return array
     */
    public function archive(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,tags'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/archive?'.http_build_query($parameters));
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param  array $parameters
     * @return array
     */
    public function unarchive(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,tags'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/unarchive?'.http_build_query($parameters));
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function pay(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:payable,transaction'
        ]);

        $response =  Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'/'.$id.'/payments?'.http_build_query($parameters), $data);
        return $this->handleResponse($response);
    }
}