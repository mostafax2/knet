<?php

use Illuminate\Support\Facades\Route;

Route::get(
  '/knet/init',
  'Mostafax\Knet\KnetController@init'
);


Route::any(
  'knet/success',
  'mostafax\knet\KnetController@success'
);

Route::any(
  'knet/error',
  'mostafax\knet\KnetController@error'
);

 

