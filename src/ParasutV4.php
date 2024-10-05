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

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->token = (new Auth($this->config))->getToken();
    }

    /**
     * @return Account
     */
    public function Account(): Account
    {
        return new Account($this->config);
    }

    /**
     * @return Transaction
     */
    public function Transaction(): Transaction
    {
        return new Transaction($this->config);
    }

    /**
     * @return Bank
     */
    public function Bank(): Bank
    {
        return new Bank($this->config);
    }

    /**
     * @return Employee
     */
    public function Employee(): Employee
    {
        return new Employee($this->config);
    }

    /**
     * @return Receipt
     */
    public function Receipt(): Receipt
    {
        return new Receipt($this->config);
    }

    /**
     * @return Salary
     */
    public function Salary(): Salary
    {
        return new Salary($this->config);
    }

    /**
     * @return Supplier
     */
    public function Supplier(): Supplier
    {
        return new Supplier($this->config);
    }

    /**
     * @return Tax
     */
    public function Tax(): Tax
    {
        return new Tax($this->config);
    }

    /**
     * @return EArchive
     */
    public function EArchive(): EArchive
    {
        return new EArchive($this->config);
    }

    /**
     * @return EBill
     */
    public function EBill(): EBill
    {
        return new EBill($this->config);
    }

    /**
     * @return ESmm
     */
    public function ESmm(): ESmm
    {
        return new ESmm($this->config);
    }

    /**
     * @return Inbox
     */
    public function Inbox(): Inbox
    {
        return new Inbox($this->config);
    }

    /**
     * @return Bill
     */
    public function Bill(): Bill
    {
        return new Bill($this->config);
    }

    /**
     * @return Customer
     */
    public function Customer(): Customer
    {
        return new Customer($this->config);
    }

    /**
     * @return Category
     */
    public function Category(): Category
    {
        return new Category($this->config);
    }

    /**
     * @return Tag
     */
    public function Tag(): Tag
    {
        return new Tag($this->config);
    }

    /**
     * @return Product
     */
    public function Product(): Product
    {
        return new Product($this->config);
    }

    /**
     * @return StockMovement
     */
    public function StockMovement(): StockMovement
    {
        return new StockMovement($this->config);
    }

    /**
     * @return Warehouse
     */
    public function Warehouse(): Warehouse
    {
        return new Warehouse($this->config);
    }

    /**
     * @return Waybill
     */
    public function Waybill(): Waybill
    {
        return new Waybill($this->config);
    }

    /**
     * @return ApiHome
     */
    public function ApiHome(): ApiHome
    {
        return new ApiHome($this->config);
    }

    /**
     * @return TrackableJob
     */
    public function TrackableJob(): TrackableJob
    {
        return new TrackableJob($this->config);
    }

    /**
     * @return Webhook
     */
    public function Webhook(): Webhook
    {
        return new Webhook($this->config);
    }

    /**
     * @param $response
     * @return array
     */
    public function handleResponse($response): array
    {
        return [
            'success' => $response->successful(),
            'error' => !$response->successful(),
            'body' => json_decode($response->body()),
            'status' => $response->status()
        ];
    }
}