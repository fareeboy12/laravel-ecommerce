<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

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

Route::get('/products', [ProductsController::class, 'getAllProducts'])->name('products.index');

Route::get('/product/{name}', [ProductsController::class, 'getSpecificProduct']);

Route::post('/products', [ProductsController::class, 'store'])->name('product.store');

Route::get('/upload-products', [ProductsController::class, 'showBulkUploadForm'])->name('upload-products');
Route::post('/products/upload', [ProductsController::class, 'uploadCsv'])->name('products.upload');

Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('update-cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeCartItem'])->name('remove-cart-item');


Route::get('/coupons/json', [CouponsController::class, 'index'])->name('coupons.index');
Route::get('/coupons', [CouponsController::class, 'create'])->name('coupons.create');
Route::post('/coupons', [CouponsController::class, 'store'])->name('coupons.store');
Route::put('/coupons/{id}', [CouponsController::class, 'update'])->name('coupons.update');
Route::delete('/coupons/{id}', [CouponsController::class, 'destroy'])->name('coupons.destroy');

//Apply coupon on checkout page
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');


// Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

//ORDER ROUTES
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/payment/{order}', [OrderController::class, 'showPayment'])->name('payment.show');
Route::get('/thankyou/{order}', [OrderController::class, 'thankyou'])->name('order.thankyou');


// Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
// Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::post('/payment/{order}', [PaymentController::class, 'store'])->name('payment.store');


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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/upload-bulk-products', function () {
        return view('layouts.csv-upload-products');
    })->name('upload-bulk-products');
});
