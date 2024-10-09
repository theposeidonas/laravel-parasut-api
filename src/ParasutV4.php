<?php

namespace Theposeidonas\LaravelParasutApi;

use Theposeidonas\LaravelParasutApi\Contracts\ParasutV4 as ParasutV4Conract;
use Theposeidonas\LaravelParasutApi\Models\Cash\Account;
use Theposeidonas\LaravelParasutApi\Models\Cash\Transaction;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Bank;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Employee;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Receipt;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Salary;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Supplier;
use Theposeidonas\LaravelParasutApi\Models\Expenses\Tax;
use Theposeidonas\LaravelParasutApi\Models\Formalization\EArchive;
use Theposeidonas\LaravelParasutApi\Models\Formalization\EBill;
use Theposeidonas\LaravelParasutApi\Models\Formalization\ESmm;
use Theposeidonas\LaravelParasutApi\Models\Formalization\Inbox;
use Theposeidonas\LaravelParasutApi\Models\Other\ApiHome;
use Theposeidonas\LaravelParasutApi\Models\Other\TrackableJob;
use Theposeidonas\LaravelParasutApi\Models\Other\Webhook;
use Theposeidonas\LaravelParasutApi\Models\Sales\Bill;
use Theposeidonas\LaravelParasutApi\Models\Sales\Customer;
use Theposeidonas\LaravelParasutApi\Models\Settings\Category;
use Theposeidonas\LaravelParasutApi\Models\Settings\Tag;
use Theposeidonas\LaravelParasutApi\Models\Stock\Product;
use Theposeidonas\LaravelParasutApi\Models\Stock\StockMovement;
use Theposeidonas\LaravelParasutApi\Models\Stock\Warehouse;
use Theposeidonas\LaravelParasutApi\Models\Stock\Waybill;

/**
 * ParasutV4
 * https://apidocs.parasut.com
 */
class ParasutV4 implements ParasutV4Conract
{
    /**
     * @array
     */
    protected array $config;

    /**
     * @string
     */
    protected string $token;

    public function __construct($config)
    {
        $this->config = $config;
        $this->token = (new Auth($this->config))->getToken();
    }

    public function Account(): Account
    {
        return new Account($this->config);
    }

    public function Transaction(): Transaction
    {
        return new Transaction($this->config);
    }

    public function Bank(): Bank
    {
        return new Bank($this->config);
    }

    public function Employee(): Employee
    {
        return new Employee($this->config);
    }

    public function Receipt(): Receipt
    {
        return new Receipt($this->config);
    }

    public function Salary(): Salary
    {
        return new Salary($this->config);
    }

    public function Supplier(): Supplier
    {
        return new Supplier($this->config);
    }

    public function Tax(): Tax
    {
        return new Tax($this->config);
    }

    public function EArchive(): EArchive
    {
        return new EArchive($this->config);
    }

    public function EBill(): EBill
    {
        return new EBill($this->config);
    }

    public function ESmm(): ESmm
    {
        return new ESmm($this->config);
    }

    public function Inbox(): Inbox
    {
        return new Inbox($this->config);
    }

    public function Bill(): Bill
    {
        return new Bill($this->config);
    }

    public function Customer(): Customer
    {
        return new Customer($this->config);
    }

    public function Category(): Category
    {
        return new Category($this->config);
    }

    public function Tag(): Tag
    {
        return new Tag($this->config);
    }

    public function Product(): Product
    {
        return new Product($this->config);
    }

    public function StockMovement(): StockMovement
    {
        return new StockMovement($this->config);
    }

    public function Warehouse(): Warehouse
    {
        return new Warehouse($this->config);
    }

    public function Waybill(): Waybill
    {
        return new Waybill($this->config);
    }

    public function ApiHome(): ApiHome
    {
        return new ApiHome($this->config);
    }

    public function TrackableJob(): TrackableJob
    {
        return new TrackableJob($this->config);
    }

    public function Webhook(): Webhook
    {
        return new Webhook($this->config);
    }

    public function handleResponse($response): array
    {
        return [
            'success' => $response->successful(),
            'error' => ! $response->successful(),
            'body' => json_decode($response->body()),
            'status' => $response->status(),
        ];
    }
}
