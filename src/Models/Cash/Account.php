<?php

namespace Theposeidonas\LaravelParasutApi\Models\Cash;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Kasa ve Banka
 * https://apidocs.parasut.com/#tag/Accounts
 */
class Account extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/accounts';
    }

    /**
     * @param  array $parameters
     * @return array
     */
    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.name' => 'nullable|string',
            'filter.currency' => 'nullable|string',
            'filter.bank_name' => 'nullable|string',
            'filter.bank_branch' => 'nullable|string',
            'filter.account_type' => 'nullable|string',
            'filter.iban' => 'nullable|string',
            'sort' => 'nullable|string|in:id,balance,balance_in_trl,-id,-balance,-balance_in_trl',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'nullable|integer|min:1|max:25'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);
        return $this->handleResponse($response);
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

    /**
     * @param string $id
     * @param array $data
     * @return array
     */
    public function edit(string $id, array $data): array
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

    /**
     * @param string $id
     * @param  array $parameters
     * @return array
     */
    public function transactions(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.date' => 'nullable|string',
            'sort' => 'nullable|string|in:id,-id',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'nullable|integer|min:1|max:25',
            'include' => 'nullable|string|in:debit_account,credit_account'
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id.'/transactions', $parameters);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function debit(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:debit_account,credit_account,payments'
        ]);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'/'.$id.'/debit_transactions?'.http_build_query($parameters), $data);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $data
     * @return array
     */
    public function credit(string $id, array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'/'.$id.'/credit_transactions', $data);
        return $this->handleResponse($response);
    }
}