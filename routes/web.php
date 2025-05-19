<?php

use App\Http\Controllers\BlogController;
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
Route::get('/order-confirmation/{order_id}', function ($order_id) {
    return view('order-confirmation', ['order_id' => $order_id]);
})->name('order.confirmation');

// Placeholder untuk riwayat pesanan (opsional, implementasi nanti)
Route::get('/orders/history', function () {
    return view('orders.history');
})->name('orders.history');


// blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/kategori/{kategoriSlug}', [BlogController::class, 'byKategori'])->name('blog.byKategori');
Route::get('/blog/tag/{tagSlug}', [BlogController::class, 'byTag'])->name('blog.byTag');
Route::get('/blog/kategori/{kategoriSlug}/tag/{tagSlug}', [BlogController::class, 'index'])->name('blog.kategori.tag');

Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'cart cleared';
});
