<?php
 

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ReviewController;
use Illuminate\Support\Facades\Route;



Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/dokan-registration', [PageController::class, 'dokan_registration'])->name('dokan_registration');
Route::get('/product/{slug}', [PageController::class, 'product'])->name('product');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/deals', [PageController::class, 'deals'])->name('deals');
Route::get('/dokanRegister', [PageController::class, 'dokanRegister'])->name('dokanRegister');


//login routes for guest (who are not logged in)
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/google/redirect', [AuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/google/callback', [AuthController::class, 'callback'])->name('google.callback');
});


// routes for who are logged in
Route::middleware('auth')->group(function(){
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

    // Cart routes
    Route::get('/index', [CartController::class, 'index'])->name('index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{cartId}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::delete('cart/removeAll', [CartController::class, 'clearAllCart'])->name('clearAllCart');
    Route::delete('/cart/clearDokanCart/{dokanId}', [CartController::class, 'clearDokanCart'])->name('clearDokanCart');

    Route::post('/cart/checkout/{dokanId}', [OrderController::class, 'checkoutDokan'])->name('cart.checkout.dokan');
    Route::get('/order/history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/khalti/callback', [OrderController::class, 'callback'])->name('khalti.callback');
    Route::get('/dokan/order/details/{record}', [OrderController::class, 'dokan_order'])->name('dokan.order.details');

});



Route::middleware('auth')->group(function () {

    // show review form
    Route::get('/product/{product}/review/create', [ReviewController::class, 'create'])
        ->name('reviews.create');

    // store review
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])
        ->name('reviews.store');
});