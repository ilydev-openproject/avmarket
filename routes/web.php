<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/toko', [TokoController::class, 'index']);
Route::get('/toko/{any}', [TokoController::class, 'detail']);
