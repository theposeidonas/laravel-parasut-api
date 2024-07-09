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
     * @var
     */
    protected $config;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return Account
     */
    public function Account(): Account
    {
        return new Account(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Transaction
     */
    public function Transaction(): Transaction
    {
        return new Transaction(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Bank
     */
    public function Bank(): Bank
    {
        return new Bank(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Employee
     */
    public function Employee(): Employee
    {
        return new Employee(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Receipt
     */
    public function Receipt(): Receipt
    {
        return new Receipt(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Salary
     */
    public function Salary(): Salary
    {
        return new Salary(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Supplier
     */
    public function Supplier(): Supplier
    {
        return new Supplier(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Tax
     */
    public function Tax(): Tax
    {
        return new Tax(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return EArchive
     */
    public function EArchive(): EArchive
    {
        return new EArchive(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return EBill
     */
    public function EBill(): EBill
    {
        return new EBill(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return ESmm
     */
    public function ESmm(): ESmm
    {
        return new ESmm(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Inbox
     */
    public function Inbox(): Inbox
    {
        return new Inbox(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Bill
     */
    public function Bill(): Bill
    {
        return new Bill(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Customer
     */
    public function Customer(): Customer
    {
        return new Customer(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Category
     */
    public function Category(): Category
    {
        return new Category(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Tag
     */
    public function Tag(): Tag
    {
        return new Tag(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Product
     */
    public function Product(): Product
    {
        return new Product(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return StockMovement
     */
    public function StockMovement(): StockMovement
    {
        return new StockMovement(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Warehouse
     */
    public function Warehouse(): Warehouse
    {
        return new Warehouse(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Waybill
     */
    public function Waybill(): Waybill
    {
        return new Waybill(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return ApiHome
     */
    public function ApiHome(): ApiHome
    {
        return new ApiHome(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return TrackableJob
     */
    public function TrackableJob(): TrackableJob
    {
        return new TrackableJob(Auth::getToken($this->config), $this->config);
    }

    /**
     * @return Webhook
     */
    public function Webhook(): Webhook
    {
        return new Webhook(Auth::getToken($this->config), $this->config);
    }
}