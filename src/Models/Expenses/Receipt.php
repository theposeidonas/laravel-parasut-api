<?php

namespace Theposeidonas\LaravelParasutApi\Models\Expenses;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Fiş Fatura
 * https://apidocs.parasut.com/#tag/PurchaseBills
 */
class Receipt extends ParasutV4
{
    private string $serviceUrl;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/purchase_bills';
    }

    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.name' => 'nullable|string',
            'filter.email' => 'nullable|string|email',
            'sort' => 'nullable|string|in:id,balance,name,email,-id,-balance,-name,-email',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'nullable|integer|min:1|max:25',
            'include' => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);

        return $this->handleResponse($response);
    }

    public function createBasic(array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'#basic?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function createDetailed(array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'#detailed?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function show(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id, $parameters);

        return $this->handleResponse($response);
    }

    public function editBasic(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->serviceUrl.'/'.$id.'#basic?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function editDetailed(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->serviceUrl.'/'.$id.'#detailed?'.http_build_query($parameters), $data);

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

    public function pay(string $id, array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:payable,transaction',
        ]);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'/'.$id.'/payments?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }

    public function cancel(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->delete($this->serviceUrl.'/'.$id.'/cancel?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function recover(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/recover?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function archive(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/archive?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function unarchive(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,spender,details,details.product,details.warehouse,payments,payments.transaction,tags,recurrence_plan,active_e_document,pay_to',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/unarchive?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }
}
