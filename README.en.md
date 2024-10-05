<a name="readme-top"></a>
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]




<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://istanbulwebtasarim.pro">
    <img src="https://istanbulwebtasarim.pro/images/istanbul-web-tasarim-logo.webp" alt="İstanbul Web Tasarım" style="width: 40%">
  </a>

<h3 align="center">Paraşüt API Laravel Package</h3>

[![Laravel][Laravel.com]][Laravel-url]
![Packagist Downloads (custom server)][downloads-url]
![Tests](https://img.shields.io/github/actions/workflow/status/theposeidonas/laravel-parasut-api/phpunit.yml?style=for-the-badge&logo=github)



  <p align="center">
   Paraşüt V4 API package for Laravel.
    <br />
    <a href="https://github.com/theposeidonas/laravel-parasut-api"><strong>Documentation »</strong></a>
    <br />
    <br />
    <a href="https://github.com/theposeidonas/laravel-parasut-api">Demo</a>
    ·
    <a href="https://github.com/theposeidonas/laravel-parasut-api/issues">Bugs</a>
    ·
    <a href="https://github.com/theposeidonas/laravel-parasut-api/issues">Issues</a>
  </p>
</div>

# Laravel Paraşüt API

This project is a package created for Laravel that allows you to easily connect with the Paraşüt V4 API. Once you enter your Paraşüt API details into the .env file, you can easily run any function you want anywhere without repeatedly dealing with Auth processes.

Türkçe dökümanı okuman için lütfen README.md dosyasına gidin.

### Why is it needed?

There are almost no fast and simple Paraşüt API packages written for Laravel. We needed a clean package that automatically handles OAuth2 processes, retrieves a new token if the previous one has expired, and allows you to simply write the operation you need in the Controller.

Please report any bugs and issues through the Issues section.


<p align="right">(<a href="#readme-top">Back to top</a>)</p>


## Starting

Be sure to contact Paraşüt and obtain the necessary information. This applies to both trial and regular accounts.


### Adding to your project

Open the terminal in your Laravel project and run the following command;

```shell
composer require theposeidonas/laravel-parasut-api
```

If needed, run the following command to share the config file;

```shell
php artisan vendor:publish --tag=parasut-config --force
```

If you are using an older version of Laravel or have Auto-Discovery disabled, add the following code to the 'aliases' section of the config/app.php file to use it everywhere;

```php
'Parasut' => Theposeidonas\LaravelParasutApi\Facades\Parasut::class,
```

### Configuration

After adding it to your project, you need to add and adjust the following lines in the .env file:
```dotenv
PARASUT_USERNAME="demo@parasut.com"  // Username
PARASUT_PASSWORD="XXXXXXXXX"  // Password
PARASUT_COMPANY_ID="123123" // Company ID
PARASUT_CLIENT_ID="XXXXXXXXXXXXXXXXX" // Paraşüt Client ID
PARASUT_CLIENT_SECRET="XXXXXXXXXXXXXXXXX" // Paraşüt Client Secret
PARASUT_REDIRECT_URI="urn:ietf:wg:oauth:2.0:oob" // Paraşüt Redirect URI, değiştirmenize gerek yok 
```
<p align="right">(<a href="#readme-top">Back to top</a>)</p>


## Usage

You need to include the package in the Controller you will use:

```php   
use Theposeidonas\LaravelParasutApi\Facades\Parasut;
```

#### Models
After completing all the settings and configurations, you can call certain classes in the Controller you will use. These classes are as follows:

```php
/* Sales */
Parasut::Bill();            // Sales Invoice            https://apidocs.parasut.com/#tag/SalesInvoices
Parasut::Customer();        // Customer                 https://apidocs.parasut.com/#tag/Contacts
        
/* Expenses */      
Parasut::Receipt();         // Receipt - Invoice        https://apidocs.parasut.com/#tag/PurchaseBills
Parasut::Bank();            // Bank Expenses            https://apidocs.parasut.com/#tag/BankFees
Parasut::Salary();          // Salary Expenses          https://apidocs.parasut.com/#tag/Salaries
Parasut::Tax();             // Tax Expenses             https://apidocs.parasut.com/#tag/Taxes
Parasut::Supplier();        // Supplier                 https://apidocs.parasut.com/#tag/Contacts
Parasut::Employee();        // Employee                 https://apidocs.parasut.com/#tag/Employees
    
/* Invoicing */ 
Parasut::Inbox();           // E-Invoice Inbox          https://apidocs.parasut.com/#tag/EInvoiceInboxes
Parasut::EArchive();        // E-Archive                https://apidocs.parasut.com/#tag/EArchives
Parasut::EBill();           // E-Invoice                https://apidocs.parasut.com/#tag/EInvoices
Parasut::ESmm();            // E-SMM                    https://apidocs.parasut.com/#tag/ESmms
    
/* Cash */ 
Parasut::Account();         // Cash and Bank            https://apidocs.parasut.com/#tag/Accounts
Parasut::Transaction();     // Transaction              https://apidocs.parasut.com/#tag/Transactions
    
/* Stock */  
Parasut::Product();         // Product                  https://apidocs.parasut.com/#tag/Products
Parasut::Warehouse();       // Warehouse                https://apidocs.parasut.com/#tag/Warehouses
Parasut::Waybill();         // Waybill                  https://apidocs.parasut.com/#tag/ShipmentDocuments
Parasut::StockMovement();   // Stock Movement           https://apidocs.parasut.com/#tag/StockMovements

/* Settings */
Parasut::Category();        // Category                 https://apidocs.parasut.com/#tag/ItemCategories
Parasut::Tag();             // Tag                      https://apidocs.parasut.com/#tag/Tags

```

_Apart from these, to check the stock level of products, you need to use ```Parasut::Product()->inventory($id); ```_

#### Methods

When using the classes within Paraşüt, you can utilize the functions listed on the https://apidocs.parasut.com page.

For example:<br>
To use the customer index function: ```Parasut::Customer()->index();```<br>
To use the customer create function: ```Parasut::Customer()->create($data);```<br>
To use the customer show function: ```Parasut::Customer()->show($id);```<br>
To use the customer edit function: ```Parasut::Customer()->edit($id, $data);```<br>

All functions shown in the documentation are available.

##### Data Structure

When sending data for a create function within a class, you must send the data as described on https://apidocs.parasut.com. If you don't provide the necessary parameters, you will receive an error.

Additionally, you must send the data as an Array, not as JSON. The package will convert the data to JSON and send it automatically.

Example of creating a Customer:
```php
$customer = [
            'data'=>[
                'type'=>'contacts',
                'attributes'=>[
                    'email'=>'demo@parasut.com',
                    'name'=>'İsim Soyisim',
                    'contact_type'=>'person',
                    'tax_number'=>'11111111111',
                    'account_type'=>'customer'
                ]
            ]
        ];
$response = Parasut::Customer()->create($customer);
```

If your operations are successful, you will receive an Array like this:

```php
Array
(
    [success] => true // If the operation is successful, true
    [error] => false // If the operation fails, true
    [body] => stdClass Object // Response as described in the Paraşüt documentation -> as stdClass Object
    [status] => 200 // Response Status
)
```

##### Query Parameters ()

Filtering and sending query parameters were included in version v1.2.0-beta. You can now send the **Query Parameters** mentioned in the documentation, which are appended to the end of the URL. The parameters are optional but may vary depending on the endpoint you are using and will be validated. You cannot send parameters that are not required.

WARNING: Before version v1.2.0, the parameter code with vkn in the Inbox was changed. So if you are using it in your project like ```Parasut::Inbox->index($vkn)```, you need to send it as an array as shown below.

```php
$parameters = [
    'filter' => [
        'vkn' => 1234567890 // Only integer accepted.
    ],
    // Not required
    'page' => [ 
        'number' => 1,
        'size'=> 15
    ]
];

Parasut::Inbox->index($parameters);
```

Example of Parameter Submission:
```php
$parameters = [
            'filter' => [
                'name' => 'isim',
                'currency' => 'TRY',
                'bank_name' => 'Banka ismi',
                'bank_branch' => 'Banka Şubesi',
                'account_type' => 'Hesap Tipi',
                'iban' => 'TR00 0000 0000 0000 0000 0000 00'
            ],
            'sort' => 'balance',
            'page' => [
                'number' => 1,
                'size' => 15
            ]
        ];
$response = Parasut::Account()->index($id, $parameters);
```
<p align="right">(<a href="#readme-top">Back to top</a>)</p>

### TODO

You can report missing parts and errors in the Issues section.
- [x] Functions have been included
- [x] Other missing parts have been added (Others)
- [x] Staging functions have been removed
- [x] Extra filters for functions will be added (Query Parameters)

<!-- LICENSE -->
## Licensing

This project is distributed under the MIT License. For more information, please refer to the 'LICENSE' file.

<p align="right">(<a href="#readme-top">Back to top</a>)</p>



<!-- CONTACT -->
## Contact

Baran Arda - [@theposeidonas](https://twitter.com/theposeidonas) - baran@webremium.com

Proje Linki: [https://github.com/theposeidonas/laravel-parasut-api](https://github.com/theposeidonas/laravel-parasut-api)

<p align="right">(<a href="#readme-top">Back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/theposeidonas/laravel-parasut-api.svg?style=for-the-badge
[contributors-url]: https://github.com/theposeidonas/laravel-parasut-api/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/theposeidonas/laravel-parasut-api.svg?style=for-the-badge
[forks-url]: https://github.com/theposeidonas/laravel-parasut-api/network/members
[stars-shield]: https://img.shields.io/github/stars/theposeidonas/laravel-parasut-api.svg?style=for-the-badge
[stars-url]: https://github.com/theposeidonas/laravel-parasut-api/stargazers
[issues-shield]: https://img.shields.io/github/issues/theposeidonas/laravel-parasut-api.svg?style=for-the-badge
[issues-url]: https://github.com/theposeidonas/laravel-parasut-api/issues
[license-shield]: https://img.shields.io/github/license/theposeidonas/laravel-parasut-api.svg?style=for-the-badge
[license-url]: https://github.com/theposeidonas/laravel-parasut-api/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/theposeidonas/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[downloads-url]: https://img.shields.io/packagist/dt/theposeidonas/laravel-parasut-api?style=for-the-badge&color=007ec6&cacheSeconds=3600