<?php

namespace Theposeidonas\LaravelParasutApi\Models\Cash;

use Illuminate\Support\Facades\Http;

/**
 * Kasa ve Banka
 * https://apidocs.parasut.com/#tag/Accounts
 */
class Account
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
        $this->baseUrl = 'https://api.parasut.com/v4/'.$this->config['company_id'].'/accounts';
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->baseUrl);
        return $this->handleResponse($response);
    }

    /**
     * @param $data
     * @return array
     */
    public function create($data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl, $data);
        return $this->handleResponse($response);
    }

    /**
     * @param $id
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
     * @param $id
     * @param $data
     * @return array
     */
    public function edit($id, $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->baseUrl.'/'.$id, $data);
        return $this->handleResponse($response);
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->delete($this->baseUrl.'/'.$id);
        return $this->handleResponse($response);
    }

    /**
     * @param $id
     * @return array
     */
    public function transactions($id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->baseUrl.'/'.$id.'/transactions');
        return $this->handleResponse($response);
    }

    /**
     * @param $id
     * @param $data
     * @return array
     */
    public function debit($id, $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl.'/'.$id.'/debit_transactions', $data);
        return $this->handleResponse($response);
    }

    /**
     * @param $id
     * @param $data
     * @return array
     */
    public function credit($id, $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl.'/'.$id.'/credit_transactions', $data);
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