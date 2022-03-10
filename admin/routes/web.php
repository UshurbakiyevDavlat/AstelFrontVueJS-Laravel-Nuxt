<?php

use Illuminate\Support\Facades\Route;
Route::get('/json', 'JsonController@json');

Route::get('/url/resolve', 'UrlController@resolve');
