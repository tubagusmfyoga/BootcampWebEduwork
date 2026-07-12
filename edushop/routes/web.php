<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Homepages';
});

Route::get('/products', function () {
    echo 'Productpages';
});

Route::get('/cart', function () {
    echo 'Cartpages';
});

Route::get('/checkout', function () {
    echo 'Checkoutpages';
});

