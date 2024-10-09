<?php

namespace Theposeidonas\LaravelParasutApi\Models\Sales;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Satış Faturası
 * https://apidocs.parasut.com/#tag/SalesInvoices
 */
class Bill extends ParasutV4
{
    private string $serviceUrl;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/sales_invoices';
    }

    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.issue_date' => 'nullable|string',
            'filter.due_date' => 'nullable|string',
            'filter.contact_id' => 'nullable|integer',
            'filter.invoice_id' => 'nullable|integer',
            'filter.invoice_series' => 'nullable|string',
            'filter.item_type' => 'nullable|string|in:invoice,refund,estimate,export',
            'filter.print_status' => 'nullable|string|in:printed,not_printed,invoices_not_sent,e_invoice_sent,e_archive_sent,e_smm_sent',
            'filter.payment_status' => 'nullable|string|in:overdue,not_due,unscheduled,paid',
            'sort' => 'nullable|string|in:id,issue_date,due_date,remaining,remaining_in_trl,description,net_total,-id,-issue_date,-due_date,-remaining,-remaining_in_trl,-description,-net_total',
            'page.number' => 'nullable|integer|min:1',
            'page.size' => 'nullable|integer|min:1|max:25',
            'include' => 'nullable|string|in:category,contact,details,details.product,details.warehouse,payments,payments.transaction,tags,sharings,recurrence_plan,active_e_document',
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
            'include' => 'nullable|string|in:category,contact,details,details.product,details.warehouse,payments,payments.transaction,tags,sharings,recurrence_plan,active_e_document',
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
            'include' => 'nullable|string|in:category,contact,details,details.product,details.warehouse,payments,payments.transaction,tags,sharings,recurrence_plan,active_e_document',
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
            'include' => 'nullable|string|in:category,contact,details,details.product,details.warehouse,payments,payments.transaction,tags,sharings,recurrence_plan,active_e_document',
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
            'include' => 'nullable|string|in:category,contact,details,details.product,details.warehouse,payments,payments.transaction,tags,sharings,recurrence_plan,active_e_document',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->delete($this->serviceUrl.'/'.$id.'/cancel?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function recover(string $id, array $parameters = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/recover?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function archive(string $id, array $parameters = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/archive?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function unarchive(string $id, array $parameters = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/unarchive?'.http_build_query($parameters));

        return $this->handleResponse($response);
    }

    public function convert(string $id, array $data, array $parameters = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/convert_to_invoice?'.http_build_query($parameters), $data);

        return $this->handleResponse($response);
    }
}
