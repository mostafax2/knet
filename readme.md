
# Knet payment Package

knet service for payment


## Acknowledgements

 - [knet payment link ](hhttps://www.knet.com.kw/)



## Installation



to install Package by composer

```composer
  composer require mostafax/knet
```

to publish my package

```composer
  php artisan vendor:publish 
```

add this keys to your env file

```env
PAYMENT_PRODUCTION_URL=https://kpay.com.kw/kpg/PaymentHTTP.htm?param=paymentInit
PAYMENT_TEST_URL=https://kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit
PAYMENT_TRANSPORT_ID=*****
PAYMENT_TRANSPORT_PASSWORD=****
PAYMENT_ACTION_CODE=1
PAYMENT_RESOURCE_KEY=**************
PAYMENT_LANGUAGE=USA
PAYMENT_CURRENCY=414
PAYMENT_ERROR_URL=http://YOURDOMAIN.test/knet/error
PAYMENT_SUCCESS_URL=http://YOURDOMAIN.test/knet/success
```


to init new link  

```php
use Mostafax\Knet\Knet;
```
```php
  $data = [
            'amount' => 20,
            'order_id' => 200,
            'track_id' => rand(0, 9999),
            'udf1' => null,
            'udf2' => null,
            'udf3' => null,
            'udf4' => null,
            'udf5' => null
        ]; 
```
```php
$Knet = new Knet();
$Knet->init($data);
``` 
## Call Back Reference

####  Payment Successful 

```http
  Post /knet/success
```

| Parameter | Type     |  
| :-------- | :------- | 
| `Payment ID` | `string` |  
| `Payment Amount` | `decimel` | 
| `Payment Date` | `date` | 
| `Payment Result` | `string` | 
| `Payment Transaction ID` | `string` | 
| `Payment Auth` | `string` | 
| `Payment Track ID` | `string` | 
| `Payment Reference Number` | `string` | 

 
####  Payment Error 

```http
  Post /knet/error
```

| Parameter | Type     |  
| :-------- | :------- | 
| `Payment ID` | `string` |  
| `Payment Amount` | `decimel` | 
| `Payment Date` | `date` | 
| `Payment Result` | `string` |   
| `Payment Track ID` | `string` |  

## Authors

- [@mostafax2](https://github.com/mostafax2)


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`PAYMENT_PRODUCTION_URL`  knet link for produuction

`PAYMENT_TEST_URL`  knet link for Test

`PAYMENT_TRANSPORT_ID` 

`PAYMENT_TRANSPORT_PASSWORD`

`PAYMENT_ACTION_CODE`

`PAYMENT_RESOURCE_KEY`

`PAYMENT_LANGUAGE` ARA or USA

`PAYMENT_CURRENCY` 

`PAYMENT_ERROR_URL`

`PAYMENT_SUCCESS_URL`

 
## you may want to disable CSRF protection 
In app/Http/Middleware/VerifyCsrfToken.php:
```php
    protected $except = [
        'knet/*'
    ];
```

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
 
 
## Tech Stack

**Client:** Blade

**Server:** PHP, Laravel


 

## Support

For support, email mostafa.m.elbiar@gmail.com.

