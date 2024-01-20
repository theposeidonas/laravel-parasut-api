<?php

namespace Theposeidonas\LaravelParasutApi\Contracts;

interface ParasutV4
{
    public function Account();
    public function Transaction();
    public function Bank();
    public function Employee();
    public function Receipt();
    public function Salary();
    public function Supplier();
    public function Tax();
    public function EArchive();
    public function EBill();
    public function ESmm();
    public function Inbox();
    public function Bill();
    public function Customer();
    public function Category();
    public function Tag();
    public function Product();
    public function StockMovement();
    public function Warehouse();
    public function Waybill();
}