<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangHilangController;
use App\Http\Controllers\Api\BarangDitemukanController;
use App\Http\Controllers\Api\KlaimController;
use App\Http\Controllers\Api\PoinController;
use App\Http\Controllers\Api\KatalogRewardController;
use App\Http\Controllers\Api\TukarPoinController;

/*
|--------------------------------------------------------------------------
| API Routes - Foundify
|--------------------------------------------------------------------------
*/

// =============================================
// PUBLIC ROUTES (Tidak perlu login)
// =============================================

Route::prefix('auth')->group(function () {
    // User Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Admin Auth
    Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
});

// Public: Lihat daftar barang (tanpa login)
Route::get('/barang-hilang', [BarangHilangController::class, 'index']);
Route::get('/barang-hilang/{id}', [BarangHilangController::class, 'show']);
Route::get('/barang-ditemukan', [BarangDitemukanController::class, 'index']);
Route::get('/barang-ditemukan/{id}', [BarangDitemukanController::class, 'show']);

// Public: Lihat katalog reward
Route::get('/katalog-reward', [KatalogRewardController::class, 'index']);
Route::get('/katalog-reward/{id}', [KatalogRewardController::class, 'show']);


// =============================================
// PROTECTED ROUTES - USER (auth:api)
// =============================================

Route::middleware('auth:api')->group(function () {

    // User Auth
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Barang Hilang
    Route::post('/barang-hilang', [BarangHilangController::class, 'store']);
    Route::put('/barang-hilang/{id}', [BarangHilangController::class, 'update']);
    Route::delete('/barang-hilang/{id}', [BarangHilangController::class, 'destroy']);
    Route::get('/my-barang-hilang', [BarangHilangController::class, 'myItems']);

    // Barang Ditemukan
    Route::post('/barang-ditemukan', [BarangDitemukanController::class, 'store']);
    Route::put('/barang-ditemukan/{id}', [BarangDitemukanController::class, 'update']);
    Route::delete('/barang-ditemukan/{id}', [BarangDitemukanController::class, 'destroy']);

    // Klaim
    Route::get('/klaim', [KlaimController::class, 'index']);
    Route::post('/klaim', [KlaimController::class, 'store']);
    Route::get('/klaim/{id}', [KlaimController::class, 'show']);
    Route::get('/my-klaim', [KlaimController::class, 'myKlaims']);

    // Poin
    Route::get('/poin', [PoinController::class, 'index']);
    Route::get('/poin/riwayat', [PoinController::class, 'riwayat']);

    // Tukar Poin (User)
    Route::post('/tukar-poin', [TukarPoinController::class, 'store']);
    Route::get('/tukar-poin/riwayat', [TukarPoinController::class, 'riwayat']);
});


// =============================================
// PROTECTED ROUTES - ADMIN (auth:admin-api)
// =============================================

Route::middleware('auth:admin-api')->group(function () {

    // Admin Auth
    Route::prefix('auth/admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logoutAdmin']);
        Route::post('/refresh', [AuthController::class, 'refreshAdmin']);
        Route::get('/me', [AuthController::class, 'meAdmin']);
    });

    // Klaim Verification (Admin Only)
    Route::put('/klaim/{id}/verify', [KlaimController::class, 'verify']);

    // Katalog Reward (Admin CRUD)
    Route::post('/katalog-reward', [KatalogRewardController::class, 'store']);
    Route::put('/katalog-reward/{id}', [KatalogRewardController::class, 'update']);
    Route::delete('/katalog-reward/{id}', [KatalogRewardController::class, 'destroy']);

    // Tukar Poin (Admin)
    Route::get('/tukar-poin', [TukarPoinController::class, 'index']);
    Route::get('/tukar-poin/{id}', [TukarPoinController::class, 'show']);
    Route::put('/tukar-poin/{id}/verify', [TukarPoinController::class, 'verify']);
});
