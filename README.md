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


  <p align="center">
    Laravel için yazılmış Paraşüt V4 API paketi.
    <br />
    <a href="https://github.com/theposeidonas/laravel-parasut-api"><strong>Dökümantasyon »</strong></a>
    <br />
    <br />
    <a href="https://github.com/theposeidonas/laravel-parasut-api">Demo</a>
    ·
    <a href="https://github.com/theposeidonas/laravel-parasut-api/issues">Buglar</a>
    ·
    <a href="https://github.com/theposeidonas/laravel-parasut-api/issues">İstekler</a>
  </p>
</div>

# Laravel Paraşüt API 

Bu proje, Laravel için oluşturulmuş kolayca Paraşüt V4 API ile bağlantı kurmanızı sağlayacak bir paket. Paraşüt API bilgilerinizi .env dosyasına girdikten sonra tekrar tekrar Auth işlemleri ile uğraşmadan kolayca istediğiniz fonksiyonu istediğiniz yerde çalıştırabilirsiniz.

### Neden ihtiyaç var?

Laravel için yazılmış hızlı ve basit bir Paraşüt API paketi neredeyse hiç bulunmuyor. OAuth2 işlemlerini otomatik olarak yapan, token süresi dolmuşsa otomatik olarak yeni token alan ve Controller içerisine sadece yapacağınız işlemi yazdıran sade bir pakete ihtiyaç duyuyorduk.

Bug ve Hataları lütfen Issues kısmından bildirin.


<p align="right">(<a href="#readme-top">Başa dön</a>)</p>


## Başlarken

Paraşüt ile mutlaka iletişime geçip gerekli bilgilerinizi alın. Bu hem deneme hesabı hem de normal hesap için geçerlidir. 


### Projenize ekleme

Laravel projenizde terminali açarak şu komutu çalıştırın;

```shell
composer require theposeidonas/laravel-parasut-api
```

Eğer gerekiyorsa config dosyasını paylaşmak için şu komutu çalıştırın;

```shell
php artisan vendor:publish --tag=parasut-config --force
```

Eğer Laravel versiyonunuz eskiyse veya Auto-Discovery kapalıysa, her yerde kullanmak için config/app.php dosyasında 'aliases' kısmına şu kodu ekleyin;

```php
'Parasut' => Theposeidonas\LaravelParasutApi\Facades\Parasut::class,
```

### Konfigürasyon

Kullanım için projenize eklemeyi yaptıktan sonra, .env dosyası içerisinde şu satırları ekleyip düzeltmelisiniz;
```dotenv
PARASUT_USERNAME="demo@parasut.com"  // Username
PARASUT_PASSWORD="XXXXXXXXX"  // Password
PARASUT_COMPANY_ID="123123" // Company ID
PARASUT_CLIENT_ID="XXXXXXXXXXXXXXXXX" // Paraşüt Client ID
PARASUT_CLIENT_SECRET="XXXXXXXXXXXXXXXXX" // Paraşüt Client Secret
PARASUT_REDIRECT_URI="urn:ietf:wg:oauth:2.0:oob" // Paraşüt Redirect URI, değiştirmenize gerek yok 
```
<p align="right">(<a href="#readme-top">Başa dön</a>)</p>


## Kullanım

Kullanacağınız Controller içerisine paketi dahil etmeniz gerekiyor;

```php   
use Theposeidonas\LaravelParasutApi\Facades\Parasut;
```

#### Sınıflar
Tüm ayarlamaları ve konfigürasyonlarınızı yaptıktan sonra kullanacağınız Controller içerisinde belirli sınıfları çağırabilirsiniz. Bu sınıflar şu şekilde;

```php
/* Satışlar */
Parasut::Bill();            // Satış faturası           https://apidocs.parasut.com/#tag/SalesInvoices
Parasut::Customer();        // Müşteri                  https://apidocs.parasut.com/#tag/Contacts
        
/* Giderler */      
Parasut::Receipt();         // Fiş - Fatura             https://apidocs.parasut.com/#tag/PurchaseBills
Parasut::Bank();            // Banka giderleri          https://apidocs.parasut.com/#tag/BankFees
Parasut::Salary();          // Maaş giderleri           https://apidocs.parasut.com/#tag/Salaries
Parasut::Tax();             // Vergi giderleri          https://apidocs.parasut.com/#tag/Taxes
Parasut::Supplier();        // Tedarikçi                https://apidocs.parasut.com/#tag/Contacts
Parasut::Employee();        // Çalışan                  https://apidocs.parasut.com/#tag/Employees
    
/* Resmileştirme */ 
Parasut::Inbox();           // E-Fatura Gelen Kutusu    https://apidocs.parasut.com/#tag/EInvoiceInboxes
Parasut::EArchive();        // E-Arşiv                  https://apidocs.parasut.com/#tag/EArchives
Parasut::EBill();           // E-Fatura                 https://apidocs.parasut.com/#tag/EInvoices
Parasut::ESmm();            // E SMM                    https://apidocs.parasut.com/#tag/ESmms
    
/* Nakit */ 
Parasut::Account();         // Kasa ve Banka            https://apidocs.parasut.com/#tag/Accounts
Parasut::Transaction();     // İşlem                    https://apidocs.parasut.com/#tag/Transactions
    
/* Stok */  
Parasut::Product();         // Ürün                     https://apidocs.parasut.com/#tag/Products
Parasut::Warehouse();       // Depo                     https://apidocs.parasut.com/#tag/Warehouses
Parasut::Waybill();         // İrsaliye                 https://apidocs.parasut.com/#tag/ShipmentDocuments
Parasut::StockMovement();   // Stok Hareketi            https://apidocs.parasut.com/#tag/StockMovements

/* Ayarlar */
Parasut::Category();        // Kategori                 https://apidocs.parasut.com/#tag/ItemCategories
Parasut::Tag();             // Etiket                   https://apidocs.parasut.com/#tag/Tags
```

_Bunlar dışında kalan, ürünlerin stok seviyesini kontrol etmek için ```Parasut::Product()->inventory($id); ``` kullanmanız gerekir._

#### Fonksiyonlar

Paraşüt içindeki sınıfları kullanırken, https://apidocs.parasut.com sayfasında yer alan fonksiyonları kullanabilirsiniz.

Örneğin;  
Müşteri index fonksiyonu için:  ```Parasut::Customer()->index(); ```  
Müşteri create fonksiyonu için: ```Parasut::Customer()->create($data); ```  
Müşteri show fonksiyonu için: ```Parasut::Customer()->show($id); ```  
Müşteri edit fonksiyonu için: ```Parasut::Customer()->edit($id, $data); ```

şeklinde kullanabilirsiniz. Dökümanlarda gösterilen tüm fonksiyonlar mevcuttur.

##### Veri Yapılandırması

Bir sınıfta create fonksiyonu için veri gönderirken, https://apidocs.parasut.com tarafında bahsedilen şekilde veri göndermelisiniz. Eğer gerekli parametreleri göndermezseniz hata alırsınız.

Ayrıca veriyi JSON olarak değil, Array olarak göndermeniz gereklidir. Paket kendisi JSON'a çevirerek gönderim yapacaktır.

Örnek Müşteri oluşturma;
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

Eğer işlemleriniz başarılıysa size şöyle bir Array geri dönecektir;

```php
Array
(
    [success] => true // İşlem başarılı ise true
    [error] => false // İşlem başarısız ise true
    [body] => stdClass Object // Paraşüt dökümanlarında yazan response -> stdClass Object olarak
    [status] => 200 // Response Status
)
```

Yani geri dönüş yapan işlemi şu şekilde sorgulayabilirsiniz;
```php
if($response['success'])
{
    // İşlem başarılı ise yapılacak şeyler
}
$customer = Parasut::Customer()->show($response['body']->data->id);
echo $customer['body']->data->attributes->name; // Oluşturulan müşterinin ismini görme


```
<p align="right">(<a href="#readme-top">Başa dön</a>)</p>

### TODO

Eksikleri ve hataları Issues kısmından yazabilirsiniz.
- [x] Fonksiyonlar dahil edildi
- [x] Eksik diğer kısımlar eklendi. (Others)
- [x] Staging fonksiyonları çıkartıldı.
- [ ] Fonksiyonların ekstra filtreleri dahil edilecek (Query Parameters)

### Changelog

#### V1.0.3

**30 Haziran 2024**

- E-Fatura gelen kutusunda parametre olarak VKN eklendi.(**[safakocamanoglu](https://github.com/safakocamanoglu)**'na teşekkürler.)

#### V1.0.2

**11 Mart 2024**

- Others altındaki fonksiyonlar eklendi.
    - ApiHome - TrackableJob - Webhook
- Config dosyasından staging çıkartıldı. (Artık kullanılmıyor)
- composer.json'a gereklilikler eklendi.

#### V1.0.1

**22 Ocak 2024**

- Satış Faturasında unutulan pay() fonksiyonu eklendi.


#### V1.0.0

**20 Ocak 2024**

- Initial Release



<p align="right">(<a href="#readme-top">Başa dön</a>)</p>

<!-- LICENSE -->
## Lisanslama

MIT Lisansı altında dağıtılmaktadır. Daha fazla bilgi için 'LICENSE' dosyasına bakın.

<p align="right">(<a href="#readme-top">Başa dön</a>)</p>



<!-- CONTACT -->
## İletişim

Baran Arda - [@theposeidonas](https://twitter.com/theposeidonas) - info@baranarda.com

Proje Linki: [https://github.com/theposeidonas/laravel-parasut-api](https://github.com/theposeidonas/laravel-parasut-api)

<p align="right">(<a href="#readme-top">Başa dön</a>)</p>


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