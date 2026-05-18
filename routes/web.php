<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\PageController;
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

});