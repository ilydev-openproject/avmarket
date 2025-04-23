<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Livewire\Livewire;
use App\Livewire\ProdukView;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/toko', [TokoController::class, 'index']);

Route::get('/toko/{kategoriSlug}', [TokoController::class, 'kategori'])->name('toko.kategori');
Route::get('/produk/{any}', [TokoController::class, 'detail']);
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// routes/web.php
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'cart cleared';
});
