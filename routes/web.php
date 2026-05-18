<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;



Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/dokan-registration', [PageController::class, 'dokan_registration'])->name('dokan_registration');
Route::get('/product/{slug}', [PageController::class, 'product'])->name('product');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/deals', [PageController::class, 'deals'])->name('deals');