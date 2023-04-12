<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponsController;

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

Route::delete('/cart/remove/{ItemId}', 'CartController@removeItem')->name('cart.removeItem');


Route::get('/coupons/json', [CouponsController::class, 'index'])->name('coupons.index');
Route::get('/coupons', [CouponsController::class, 'create'])->name('coupons.create');
Route::post('/coupons', [CouponsController::class, 'store'])->name('coupons.store');
Route::put('/coupons/{id}', [CouponsController::class, 'update'])->name('coupons.update');
Route::delete('/coupons/{id}', [CouponsController::class, 'destroy'])->name('coupons.destroy');



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
