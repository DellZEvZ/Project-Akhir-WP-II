<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatalogApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\BookingApiController;

// ===== Publik (tanpa token) =====
Route::get('/layanan',      [CatalogApiController::class, 'layanan']);
Route::get('/layanan/{id}', [CatalogApiController::class, 'layananShow']);
Route::get('/produk',       [CatalogApiController::class, 'produk']);
Route::get('/produk/{id}',  [CatalogApiController::class, 'produkShow']);
Route::get('/barber',       [CatalogApiController::class, 'barber']);
Route::get('/galeri',       [CatalogApiController::class, 'galeri']);

// Auth customer
Route::post('/register', [CustomerApiController::class, 'register']);
Route::post('/login',    [CustomerApiController::class, 'login']);

// ===== Terproteksi (Bearer token) =====
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [CustomerApiController::class, 'logout']);
    Route::get('/me',      [CustomerApiController::class, 'me']);

    Route::get('/booking',          [BookingApiController::class, 'index']);
    Route::post('/booking',         [BookingApiController::class, 'store']);
    Route::get('/booking/{id}',     [BookingApiController::class, 'show']);
    Route::post('/booking/{id}/pay', [BookingApiController::class, 'pay']);
});
