<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     echo 'Homepages';
// });
Route::get('/', [HomeController::class, 'index']);

Route::prefix('admin')->group(function() {
    Route::get('/dashboard', function() {
        echo "Admin Dashboard";
    });
    Route::resource('products', ProductController::class);
});


Route::get('/products', function () {
    echo 'Productpages';
});

Route::get('/product-details', [HomeController::class, 'productDetails']);

Route::get('/cart', function () {
    echo 'Cartpages';
});

Route::get('/checkout', function () {
    echo 'Checkoutpages';
});

