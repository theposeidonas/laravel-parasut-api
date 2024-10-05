<?php

namespace Theposeidonas\LaravelParasutApi\Models\Stock;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Stok Hareketleri
 * https://apidocs.parasut.com/#tag/StockMovements
 */
class StockMovement extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/stock_movements';
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'sort'        => 'nullable|string|in:id,date,-id,-date',
            'page.number' => 'nullable|integer|min:1',
            'page.size'   => 'nullable|integer|min:1|max:25',
            'include'     => 'nullable|string|in:product,source,contact,warehouse',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);
        return $this->handleResponse($response);
    }

}