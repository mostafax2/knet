<?php

use Illuminate\Support\Facades\Route;

Route::get(
  '/knet/init',
  'Mostafax\Knet\Knet@init'
);


Route::any(
  'knet/success',
  'mostafax\knet\Knet@success'
);

Route::any(
  'knet/error',
  'mostafax\knet\Knet@error'
);

 

