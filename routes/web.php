<?php

use Livewire\Livewire;
use App\Livewire\ProdukView;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/toko', [TokoController::class, 'index']);

Route::get('/toko/{kategoriSlug}', [TokoController::class, 'kategori'])->name('toko.kategori');
Route::get('/produk/{any}', [TokoController::class, 'detail']);

Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'cart cleared';
});
