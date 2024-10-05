<?php

namespace Theposeidonas\LaravelParasutApi\Models\Stock;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Ürün
 * https://apidocs.parasut.com/#tag/Products
 */
class Product extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/products';
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.name'        => 'nullable|string',
            'filter.code'        => 'nullable|string',
            'sort'               => 'nullable|string|in:id,name,-id,-name',
            'page.number'        => 'nullable|integer|min:1',
            'page.size'          => 'nullable|integer|min:1|max:25',
            'include'            => 'nullable|string|in:inventory_levels,category',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);
        return $this->handleResponse($response);
    }

    /**
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function create(array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:inventory_levels,category',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'?'.http_build_query($parameters), $data);
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
            'include' => 'nullable|string|in:inventory_levels,category',
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
            'include' => 'nullable|string|in:inventory_levels,category',
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
     * https://apidocs.parasut.com/#operation/listInventoryLevels
     *
     * @param string $id
     * @param array $parameters
     * @return array
     */
    public function inventory(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.warehouses.name' => 'nullable|string',
            'filter.archived'        => 'nullable|boolean',
            'filter.has_stock'       => 'nullable|boolean',
            'filter.stock_count'     => 'nullable|numeric',
            'sort'                   => 'nullable|string|in:id,stock_count,-id,-stock_count',
            'page.number'            => 'nullable|integer|min:1',
            'page.size'              => 'nullable|integer|min:1|max:25',
            'include'                => 'nullable|string|in:product,warehouse',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id.'/inventory_levels', $parameters);
        return $this->handleResponse($response);
    }

}