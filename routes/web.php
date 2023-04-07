<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/products', [ProductsController::class, 'getAllProducts']);

Route::get('/product/{name}', [ProductsController::class, 'getSpecificProduct']);

Route::post('/products', [ProductsController::class, 'store'])->name('product.store');

Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

Route::post('/cart/update-quantity', 'CartController@updateQuantity')->name('cart.updateQuantity');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/add-new-product', function () {
        return view('layouts.add-new-product');
    })->name('add-new-product');
});
