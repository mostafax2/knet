<?php

use Illuminate\Support\Facades\Route;



Route::get(
    'knet/check/{paymentId}/{amount}',
     'Mostafax\Knet\KnetController@checkPayment'
     );


Route::get(
  '/knet/init',
  'Mostafax\Knet\KnetController@init'
);

Route::get(
    '/knet/form',
    'Mostafax\Knet\KnetController@form'
  );


Route::any(
  'en/knet/success',
  'Mostafax\Knet\KnetController@success'
);

Route::any(
  'knet/error',
  'Mostafax\Knet\KnetController@error'
);



