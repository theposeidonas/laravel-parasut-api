<?php

namespace Theposeidonas\LaravelParasutApi\Models\Stock;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * İrsaliye
 * https://apidocs.parasut.com/#tag/ShipmentDocuments
 */
class Waybill extends ParasutV4
{
    private string $serviceUrl;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/shipment_documents';
    }

    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.flow_type' => 'nullable|string',
            'filter.invoice_status' => 'nullable|string',
            'filter.archived' => 'nullable|boolean',
            'sort' => 'nullable|string|in:id,issue_date,description,inflow,-id,-issue_date,-description,-inflow',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'nullable|integer|min:1|max:25',
            'include' => 'nullable|string|in:contact,stock_movements,stock_movements.product,tags,invoices',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);

        return $this->handleResponse($response);
    }

    public function create(array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:contact,stock_movements,stock_movements.product,tags,invoices',
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
            'include' => 'nullable|string|in:contact,stock_movements,stock_movements.product,tags,invoices',
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
            'include' => 'nullable|string|in:contact,stock_movements,stock_movements.product,tags,invoices',
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
}
