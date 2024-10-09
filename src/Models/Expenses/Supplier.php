<?php

namespace Theposeidonas\LaravelParasutApi\Models\Expenses;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Tedarikçi
 * https://apidocs.parasut.com/#tag/Contacts
 */
class Supplier extends ParasutV4
{
    private string $serviceUrl;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/contacts';
    }

    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.name' => 'nullable|string',
            'filter.email' => 'nullable|string',
            'filter.tax_number' => 'nullable|string',
            'filter.tax_office' => 'nullable|string',
            'filter.city' => 'nullable|string',
            'filter.account_type' => 'nullable|string|in:customer,supplier',
            'sort' => 'nullable|string|in:id,balance,name,email,-id,-balance,-name,-email',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'nullable|integer|min:1|max:25',
            'include' => 'nullable|string|in:category,contact_portal,contact_people',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);

        return $this->handleResponse($response);
    }

    public function create(array $data, array $parameters): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,contact_portal,contact_people',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function show(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,contact_portal,contact_people',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id, $parameters);

        return $this->handleResponse($response);
    }

    public function edit(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,contact_portal,contact_people',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->serviceUrl.'/'.$id.'?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function delete(string $id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->delete($this->serviceUrl.'/'.$id);

        return $this->handleResponse($response);
    }

    public function collect(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:debit_account,credit_account,payments',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'/'.$id.'/contact_debit_transactions?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function pay(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:debit_account,credit_account,payments',
        ]);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'/'.$id.'/contact_credit_transactions?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }
}
