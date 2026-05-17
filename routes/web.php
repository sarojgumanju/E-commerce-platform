<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;



Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/dokan-registration', [PageController::class, 'dokan_registration'])->name('dokan_registration');