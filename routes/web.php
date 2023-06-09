<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewsController;

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



Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('update-cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeCartItem'])->name('remove-cart-item');




Route::get('/coupons/json', [CouponsController::class, 'index'])->name('coupons.index');
Route::get('/coupons', [CouponsController::class, 'create'])->name('coupons.create');

//Apply coupon on checkout page
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

//ORDER ROUTES
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/payment/{order}', [OrderController::class, 'showPayment'])->name('payment.show');
Route::get('/thankyou/{order}', [OrderController::class, 'thankyou'])->name('order.thankyou');


Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{order}', [PaymentController::class, 'store'])->name('payment.store');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('/wishlists', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');

    Route::get('/dashboard', [])->name('dashboard.index');
    Route::get('/accounts', [DashboardController::class, 'index'])->name('accounts.index');

    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
    // Route::post('products/{productId}/reviews', [ReviewsController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/create/{product_id}', [ReviewsController::class, 'store'])->name('reviews.store');
});


//FOR ADMIN PANEL
Route::middleware(['auth', 'userType'])->group(function () {
    // Route::get('/get-statistics', [DashboardController::class, 'getStatistics'])->name('get-statistics');
    Route::get('/upload-products', [ProductsController::class, 'showBulkUploadForm'])->name('upload-products');
    Route::post('/products/upload', [ProductsController::class, 'uploadCsv'])->name('products.upload');
    Route::post('/coupons', [CouponsController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{id}', [CouponsController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [CouponsController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/order-details/{id}', [OrderController::class, 'show'])->name('order-details');
    Route::post('/update-order-status/{order}', [OrderController::class, 'updateOrderStatus']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/all-orders', [OrderController::class, 'index'])->name('all-orders');
    Route::get('/upload-bulk-products', function () {
        return view('layouts.csv-upload-products');
    })->name('upload-bulk-products');

    Route::get('/add-new-product', function () {
        return view('layouts.add-new-product');
    })->name('add-new-product');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'getStatistics'])->name('dashboard');

    Route::get('/cart/details', [CartController::class, 'showCartDetails'])->name('cart.details');

    Route::get('/manage-products', [ProductsController::class, 'manageProducts'])->name('manage-products');
    Route::get('/update-product/{slug}', [ProductsController::class, 'updateProducts'])->name('update-product');

});