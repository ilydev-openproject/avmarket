<?php

use Livewire\Livewire;
use App\Livewire\ProdukView;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleLoginController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/toko', [TokoController::class, 'index']);

Route::get('/toko/{kategoriSlug}', [TokoController::class, 'kategori'])->name('toko.kategori');
Route::get('/produk/{any}', [TokoController::class, 'detail']);
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


Route::get('/profile', [Profile::class, 'index'])->name('profile');


// routes/web.php
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'cart cleared';
});
