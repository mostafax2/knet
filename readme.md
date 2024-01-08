
# Knet payment Package

knet service for payment


## Acknowledgements

 - [knet payment link ](hhttps://www.knet.com.kw/)



## Installation



to install Package by composer

```bash
  composer require mostafax/knet
```

to publish my package

```bash
  php artisan vendor:publish 
```

add this keys to your env file

```bash
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

```bash
use Mostafax\Knet\KnetController;
```
```php
 $data = [
            'amount' => 20,
            'track_id' => rand(0, 9999),
            'udf1' => null,
            'udf2' => null,
            'udf3' => null,
            'udf4' => null,
            'udf5' => null
        ];
```
```php
$KnetController = new KnetController();
$KnetController->init($data);
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

 
## Badges

Add badges from somewhere like: [shields.io](https://shields.io/)

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
[![GPLv3 License](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://opensource.org/licenses/)
[![AGPL License](https://img.shields.io/badge/license-AGPL-blue.svg)](http://www.gnu.org/licenses/agpl-3.0)


## Used By

This project is used by the following companies:

- Company 1
- Company 2


## Tech Stack

**Client:** Blade

**Server:** PHP, Laravel


## Running Tests

To run tests, run the following command

```bash
  npm run test
```


## Support

For support, email fake@fake.com or join our Slack channel.

