<?php

namespace Theposeidonas\LaravelParasutApi\Models\Formalization;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * E-Fatura Gelen Kutusu
 * https://apidocs.parasut.com/#tag/EInvoiceInboxes
 */
class Inbox extends ParasutV4
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
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/e_invoice_inboxes';
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.vkn'     => 'nullable|integer',
            'page.number'    => 'nullable|integer|min:1',
            'page.size'      => 'nullable|integer|min:1|max:25',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);
        return $this->handleResponse($response);
    }

}