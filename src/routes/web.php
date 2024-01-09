<?php

use Illuminate\Support\Facades\Route;

Route::get(
  '/knet/init',
  'Mostafax\Knet\Knet@init'
);


Route::any(
  'knet/success',
  'Mostafax\Knet\Knet@success'
);

Route::any(
  'knet/error',
  'Mostafax\Knet\Knet@error'
);

 

