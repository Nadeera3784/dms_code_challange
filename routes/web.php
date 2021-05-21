<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\AppController::class, 'index'])->name('home');
Route::get('/category/{slug}', [App\Http\Controllers\AppController::class, 'category'])->name('category');
Route::get('/cart/', [App\Http\Controllers\AppController::class, 'cart'])->name('cart');
Route::post('/add/cart/{product_id}', [App\Http\Controllers\AppController::class, 'addToCart'])->name('cart.store');
Route::post('/update/cart/', [App\Http\Controllers\AppController::class, 'updateCart'])->name('cart.update');
Route::post('/remove/cart/', [App\Http\Controllers\AppController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout/', [App\Http\Controllers\AppController::class, 'checkout'])->name('checkout');
Route::post('/payment/', [App\Http\Controllers\AppController::class, 'payment'])->name('payment');
Route::post('/check/coupon/', [App\Http\Controllers\AppController::class, 'checkCoupon'])->name('check.coupon');
